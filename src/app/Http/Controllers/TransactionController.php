<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatRequest;
use Illuminate\Http\Request;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

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

        return view('chat', compact('purchase', 'item', 'chats', 'partner', 'user','listItems'));
    }

    public function sendChat(ChatRequest $request, Purchase $purchase)
        {
            $this->authorize('view', $purchase);

            $purchase->chats()->create([
                'purchase_id' => $purchase->id,
                'user_id' => auth()->id(),
                'message' => $request->message,
                //'image_path' => $request->image_path,
            ]);
            return back();
        }
}