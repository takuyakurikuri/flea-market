<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function show(Purchase $purchase)
{
    $this->authorize('view', $purchase); // ポリシー

    $user = Auth::user();
    $item = $purchase->item;
    $chats = $purchase->chats()->with('user')->latest()->get();

    // 取引相手の名前
    $partner = $purchase->user_id === $user->id
        ? $item->user  // 出品者
        : $purchase->user; // 購入者

    return view('chat', compact('purchase', 'item', 'chats', 'partner', 'user'));
}

public function sendChat(Request $request, Purchase $purchase)
{
    $this->authorize('view', $purchase);

    $request->validate([
        'message' => 'required|string|max:1000',
    ]);

    $purchase->chats()->create([
        'user_id' => auth()->id(),
        'message' => $request->message,
    ]);

    return back();
}
}