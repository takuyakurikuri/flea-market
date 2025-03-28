<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Models\Purchase;
use App\Http\Requests\AddressRequest;
use App\Http\Requests\PurchaseRequest;

class PurchaseController extends Controller
{
    public function purchase($item_id){
        $item =  item::find($item_id);
        $user = Auth::user();
        $zip1 = substr($user->profile->address->zipcode,0,3);
        $zip2 = substr($user->profile->address->zipcode,3);
        $zipcode = $zip1 . "-" . $zip2;
        $changeAddress = false;
        return view('purchase',compact('item','user','zipcode','changeAddress'));
    }

    public function formAddress($item_id){
        $item = item::find($item_id);
        return view('change_address',compact('item'));
    }

    public function changeAddress($item_id, AddressRequest $request){
        $zip1 = substr($request->zipcode,0,3);
        $zip2 = substr($request->zipcode,3);
        $zipcode = $zip1 . "-" . $zip2;
        $changeAddress = [
            'zipcode' => $zipcode,
            'address' => $request->address,
            'building' => $request->building,
        ];
        return redirect()->route('item.purchase',['item_id'=>$item_id])->with('message','住所を変更しました')->with('changeAddress',$changeAddress);
    }

    public function buy(PurchaseRequest $request){
        $user = Auth::user();
        $zip1 = substr($request->zipcode,0,3);
        $zip2 = substr($request->zipcode,4);
        $zipcode = $zip1 . $zip2;
        $purchase = purchase::create([
            'user_id' => $user->id,
            'payment_method' => $request->payment_method,
            'purchase_zipcode' => $zipcode,
            'purchase_address' => $request->address,
            'purchase_building' => $request->building
        ]);

        item::find($request->purchase_item_id)->update([
            'purchase_id'=> $purchase->id
        ]);
        return redirect('/')->with('message','商品を購入しました');
    }
}