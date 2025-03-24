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
use App\Models\Profile;
use App\Models\Item;
use App\Actions\Auth\CustomAttemptToAuthenticate;
use App\Models\User;
use App\Models\Address;
use App\Models\Purchase;

class AuthController extends Controller
{

    protected $guard;

    public function __construct(StatefulGuard $guard)
    {
        $this->guard = $guard;
    }

    public function store(RegisterRequest $request, CreatesNewUsers $creator): RegisterResponse
    {
        event(new Registered($user = $creator->create($request->all())));

        $this->guard->login($user);

        //2要素認証実装時はルートサービスプロバイダ側で処理を変える
        return app(RegisterResponse::class);

        // ユーザー登録
        //$user = $creator->create($request->all());

        // メール認証メール送信
        //event(new Registered($user));

        // ユーザーをログインさせない（未認証のまま）
        //return redirect()->route('verification.notice');
    }

    public function login(LoginRequest $request)
    {
        return $this->loginPipeline($request)->then(function ($request) {
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
    
    public function profileRegister(Request $request) {
        $user_image_path = null;
        if ($request->hasFile('user_image_path')) {
            // 画像を 'storage/app/public/images' に保存し、保存されたパスを取得
            $user_image_path = $request->file('user_image_path')->store('images', 'public');
        }

        $address = address::create([
            'zipcode' => $request['zipcode'],
            'address' => $request['address'],
            'building' => $request['building'],
        ]);
        
        Profile::create([
            'user_id' => $request['user_id'],
            'user_image_path' => $user_image_path,
            'address_id' => $address->id
            //'zipcode' => $request['zipcode'],
            //'address' => $request['address'],
            //'building' => $request['building'],
        ]);

        return redirect('/mypage')->with('success','プロフィール登録が完了しました');
    }

    public function modifyProfile(Request $request){

        $user_image_path = null;
        if ($request->hasFile('user_image_path')) {
            // 画像を 'storage/app/public/images' に保存し、保存されたパスを取得
            $user_image_path = $request->file('user_image_path')->store('images', 'public');
        }
        else {
            $user_image_path = $request->existing_user_image_path;
        }

        Profile::find($request->user_id)->update([
            'user_image_path' => $user_image_path,
            //'zipcode' => $request['zipcode'],
            //'address' => $request['address'],
            //'building' => $request['building'],
        ]);

        $profile = Profile::find($request->user_id);

        address::find($profile->address_id)->update([
            'zipcode' => $request['zipcode'],
            'address' => $request['address'],
            'building' => $request['building'],
        ]);

        User::find($request->user_id)->update([
            'name' => $request['name'],
        ]);
        
        return redirect('/mypage')->with('message','プロフィールの修正を行いました');
    }

    public function mypage(Request $request){
        if($request->tab == 'buy' && Auth::check()){
            $user = Auth::user();
            $items = auth()->user()->purchaseItem()->get();
        }
        else{
            $user = Auth::user();
            $items = Item::where('exhibitor_id',$user->id)->get();
        }
        return view('mypage' ,compact('items','user'));
    }

}