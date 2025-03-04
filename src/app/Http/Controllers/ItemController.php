<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\ProductCategory;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index() {
        $items = Item::all();
        return view('index',compact('items'));
    }

    public function sellRegister(){
        $categories = ProductCategory::all();
        $conditions = Condition::all();
        return view('sell',compact('categories','conditions'));
    }

    public function sell(Request $request) {
        $product_image_path = null;
        if ($request->hasFile('product_image_path')) {
            // 画像を 'storage/app/public/images' に保存し、保存されたパスを取得
            $product_image_path = $request->file('product_image_path')->store('images', 'public');
        }
        
        $user = Auth::user();

        Item::create([
        'exhibitor_id' => $user->id,
        'product_image_path' => $product_image_path,
        'product_category_id' => $request['product_category_id'],
        'condition_id' => $request['condition_id'],
        'product_name' => $request['product_name'],
        'product_brand' => $request['product_brand'],
        'product_detail' => $request['product_detail'],
        'product_price' => $request['product_price']
        ]);

        return redirect('/')->with('success','商品の出品に成功しました');
    }

    public function itemDetail($item_id) {
        $item = Item::find($item_id);
        return view('detail',compact('item'));
    }

}