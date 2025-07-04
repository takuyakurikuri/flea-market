<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUsers;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\RegisterResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use App\Http\Requests\LoginRequest;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Fortify;
use Illuminate\Routing\Pipeline;
use Laravel\Fortify\Actions\EnsureLoginIsNotThrottled;
use Laravel\Fortify\Actions\PrepareAuthenticatedSession;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Actions\CanonicalizeUsername;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Actions\Auth\CustomAttemptToAuthenticate;
use App\Models\User;
use App\Models\Address;
use App\Models\Purchase;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Support\Carbon;
use App\Http\Requests\AddressRequest;
use App\Models\TransactionReview;
use App\Models\TransactionChat;

class AuthController extends Controller
{

    protected $guard;

    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    public function store(RegisterRequest $request, CreatesNewUsers $creator): RegisterResponse
    {

        $user = $creator->create($request->all());

        $user->sendEmailVerificationNotification();

        return app(RegisterResponse::class);
    }

    public function verifyEmail($id){
        $user = User::find($id);

        if ($user->hasVerifiedEmail()) {
            return redirect('/mypage/profile')->with('message', 'すでに認証済みです。');
        }

        $user->forceFill([
            'email_verified_at' => Carbon::now(),
        ])->save();

        Auth::login($user);

        return redirect('/mypage/profile')->with('message', 'メール認証が完了しました。');
    }

    public function login(LoginRequest $request)
    {
        return $this->loginPipeline($request)->then(function ($request) {
            $user = auth()->user();

            if (!$user->hasVerifiedEmail()) {
                auth()->logout();
                return redirect()->route('verification.notice')
                    ->with('error', 'メール認証を完了してください。');
            }

            return app(LoginResponse::class);
        });
    }

    //ログインに関するpipelineの処理を丸ごと拡張
    protected function loginPipeline(LoginRequest $request)
    {
        if (Fortify::$authenticateThroughCallback) {
            return (new Pipeline(app()))->send($request)->through(array_filter(
                call_user_func(Fortify::$authenticateThroughCallback, $request)
            ));
        }

        if (is_array(config('fortify.pipelines.login'))) {
            return (new Pipeline(app()))->send($request)->through(array_filter(
                config('fortify.pipelines.login')
            ));
        }

        return (new Pipeline(app()))->send($request)->through(array_filter([
            config('fortify.limiters.login') ? null : EnsureLoginIsNotThrottled::class,
            config('fortify.lowercase_usernames') ? CanonicalizeUsername::class : null,
            Features::enabled(Features::twoFactorAuthentication()) ? RedirectIfTwoFactorAuthenticatable::class : null,
            //AttemptToAuthenticate::class,
            CustomAttemptToAuthenticate::class,
            PrepareAuthenticatedSession::class,
        ]));
    }

    public function profile(){
        $user = Auth::user();
        return view('profile' ,compact('user'));
    }
    
    public function profileRegister(AddressRequest $request) {
        $image_path = null;
        if ($request->hasFile('image_path')) {
            // 画像を 'storage/app/public/images' に保存し、保存されたパスを取得
            $image_path = $request->file('image_path')->store('images', 'public');
        }

        $address = address::create([
            'zipcode' => $request['zipcode'],
            'address' => $request['address'],
            'building' => $request['building'],
        ]);
        
        user::find($request->user_id)->update([
            'image_path' => $image_path,
            'address_id' => $address->id,
            'name' => $request['name']
        ]);

        return redirect('/mypage')->with('success','プロフィール登録が完了しました');
    }

    public function modifyProfile(AddressRequest $request){

        $image_path = null;
        if ($request->hasFile('image_path')) {
            // 画像を 'storage/app/public/images' に保存し、保存されたパスを取得
            $image_path = $request->file('image_path')->store('images', 'public');
        }
        else {
            $image_path = $request->existing_image_path;
        }

        $address = address::create([
            'zipcode' => $request['zipcode'],
            'address' => $request['address'],
            'building' => $request['building'],
        ]);

        User::find($request->user_id)->update([
            'name' => $request['name'],
            'image_path' => $image_path,
            'address_id' => $address->id,
        ]);
    
        return redirect('/mypage')->with('message','プロフィールの修正を行いました');
    }

    public function mailVerify(Request $request){
        return view('auth.mail_verification');
    }

    public function resendEmail(Request $request){
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }

    public function mypage(Request $request){
        $user = Auth::user();

        $avgRating = TransactionReview::where('reviewee_id', $user->id)->avg('rating');

        switch ($request->tab) {
            case 'buy':
                $items = $user->purchasedItems;
                break;

            case 'trading':
            $items = Item::whereHas('purchases') // ← 条件を緩和
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('purchases', function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    });
            })
            ->with(['purchases' => function ($query) use ($user) {
                $query->with(['chats' => function ($q) {
                    $q->latest(); 
                }])
                ->withCount([
                    'chats as unread_count' => function ($q) use ($user) {
                        $q->where('user_id', '!=', $user->id)
                        ->whereNull('read_at');
                    }
                ]);
            }])
            ->get();

            // purchase の中の最新チャット日時を取得して並べ替え
            $items = $items->sortByDesc(function ($item) use ($user) {
                $relatedPurchase = $item->purchases->firstWhere('user_id', $user->id)
                    ?? $item->purchases->first();

                return optional($relatedPurchase->chats->first())->created_at;
            });
            break;

            default:
                $items = Item::where('user_id', $user->id)->get();
        }

        $totalUnreadCount = 0;

        $totalUnreadCount = TransactionChat::whereHas('purchase', function ($query) use ($user) {
            $query->where('status', '!=', 'completed')
                  ->where(function ($q) use ($user) {
                      $q->where('user_id', $user->id)
                        ->orWhereHas('item', function ($q2) use ($user) {
                            $q2->where('user_id', $user->id);
                        });
                  });
        })
        ->where('user_id', '!=', $user->id)
        ->whereNull('read_at')
        ->count();

        return view('mypage', compact('items', 'user','avgRating','totalUnreadCount'));
    }

}