<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseRequest;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Models\Purchase;

class StripeController extends Controller
{


    public function checkout(PurchaseRequest $request, $item_id)
    {

        $user = Auth::user();
        $zip1 = substr($request->zipcode,0,3);
        $zip2 = substr($request->zipcode,4);
        $zipcode = $zip1 . $zip2;
        
        if($request->modify == 'true'){
            $address = address::create([
                'zipcode' => $zipcode,
                'address' => $request->address,
                'building' => $request->building
            ]);
            
            purchase::create([
                'user_id' => $user->id,
                'address_id' => $address->id,
                'item_id' => $request->item_id,
                'payment_method' => $request->payment_method,
            ]);

            return redirect('$session->url')->with('message','発送先を変更し、商品を購入しました');
        }

        purchase::create([
            'user_id' => $user->id,
            'payment_method' => $request->payment_method,
            'item_id' => $request->item_id,
            'address_id' => $user->address_id
        ]);
        
        // 商品情報を取得
        $item = \App\Models\Item::findOrFail($item_id);

        // Stripeの秘密鍵を設定
        Stripe::setApiKey(config('services.stripe.secret'));

        // Stripe Checkoutセッションを作成
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $item->name,
                    ],
                    'unit_amount' => $item->price
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('checkout.success'),
            'cancel_url' => route('checkout.cancel'),
        ]);

        return redirect($session->url);
    }

    public function success()
    {
        return view('checkout.success');
    }

    public function cancel()
    {
        return view('checkout.cancel');
    }

}