<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatRequest;
use Illuminate\Http\Request;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\TransactionChat;
use Illuminate\Support\Facades\Mail;
use App\Mail\TransactionCompleted;
use App\Models\TransactionReview;
use Illuminate\Support\Facades\Storage;

class TransactionController extends Controller
{
    public function show(Purchase $purchase)
    {
        $this->authorize('view', $purchase);

        $user = Auth::user();
        $item = $purchase->item()->with('exhibitor')->first(); 
        $chats = $purchase->chats()->with('user')->oldest()->get();


        $listItems = Item::whereHas('purchases', function ($query) {
            $query->where('status', '!=', 'completed');
        })->where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->orWhereHas('purchases', function ($q) use ($user) {
                      $q->where('user_id', $user->id);
                  });
        })
        ->with('purchases')
        ->get();

        // 取引相手の名前
        $partner = $purchase->user_id === $user->id
            ? $item->exhibitor // 出品者
            : $purchase->user; // 購入者

        $shouldShowModal = $purchase->status ==='completed' && $purchase->reviews->where('reviewer_id',auth()->id())->isEmpty();

        //既読処理
        TransactionChat::where('purchase_id', $purchase->id)
        ->where('user_id', '!=', auth()->id())
        ->whereNull('read_at')
        ->update(['read_at' => now()]);

        return view('chat', compact('purchase', 'item', 'chats', 'partner', 'user','listItems','shouldShowModal'));
    }

    public function sendChat(ChatRequest $request, Purchase $purchase)
        {
            $this->authorize('view', $purchase);

            $image_path = null;
        if ($request->hasFile('image_path')) {
            // 画像を 'storage/app/public/images' に保存し、保存されたパスを取得
            $image_path = $request->file('image_path')->store('images', 'public');
        }

            $purchase->chats()->create([
                'purchase_id' => $purchase->id,
                'user_id' => auth()->id(),
                'message' => $request->message,
                'image_path' => $image_path,
            ]);
            return back();
        }

        public function transactionCompleted(Purchase $purchase){

            $this->authorize('view', $purchase);
            
            $purchase->update([
                'status' => 'completed',
            ]);

            $seller = $purchase->user;
            Mail::to($seller->email)->send(new transactionCompleted($purchase));

            return redirect()->route('chat.show', $purchase);
        }

        public function storeReview(Request $request)
        {
            TransactionReview::create($request->only([
                'purchase_id', 'reviewer_id', 'reviewee_id', 'rating',
            ]));

            return redirect('/mypage')->with('success', '評価を送信しました');
        }

        public function deleteChat(Purchase $purchase, TransactionChat $chat){

            $this->authorize('view', $purchase);

            $chat->delete();
            return back();
        }

        
        public function correctChat(Request $request, Purchase $purchase, TransactionChat $chat)
        {

            $chat->message = $request->message;

            if ($request->hasFile('image_path')) {
                if ($chat->image_path) {
                    Storage::delete($chat->image_path);
                }
                $chat->image_path = $request->file('image_path')->store('chat_images', 'public');
            }

            $chat->save();

            return redirect()->back()->with('success', 'メッセージを編集しました');
        }
}