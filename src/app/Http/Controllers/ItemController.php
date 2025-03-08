<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\ItemCategory;
use App\Models\Condition;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;
use App\Models\Comment;

class ItemController extends Controller
{
    public function index() {
        $items = Item::all();
        return view('index',compact('items'));
    }

    public function sellRegister(){
        $categories = ItemCategory::all();
        $conditions = Condition::all();
        return view('sell',compact('categories','conditions'));
    }

    public function sell(Request $request) {
        $item_image_path = null;
        if ($request->hasFile('item_image_path')) {
            // 画像を 'storage/app/public/images' に保存し、保存されたパスを取得
            $item_image_path = $request->file('item_image_path')->store('images', 'public');
        }
        
        $user = Auth::user();

        Item::create([
        'exhibitor_id' => $user->id,
        'item_image_path' => $item_image_path,
        'item_category_id' => $request['item_category_id'],
        'condition_id' => $request['condition_id'],
        'product_name' => $request['product_name'],
        'product_brand' => $request['product_brand'],
        'product_detail' => $request['product_detail'],
        'product_price' => $request['product_price']
        ]);

        return redirect('/')->with('success','商品の出品に成功しました');
    }

    public function itemDetail($item_id) {
        $item = Item::findOrFail($item_id);
        $isFavorite = Auth::check() ? favorite::where('item_id',$item_id)->where('user_id',Auth::id())->exists() : false;
        return view('detail',compact('item','isFavorite'));
    }

    public function addFavorite(Request $request){
        Favorite::create([
            'user_id' => Auth::id(),
            'product_id' => $request->item_id
        ]);

        return redirect('/item/{item_id}')->with('message','お気に入りに追加しました');
    }

    public function destroyFavorite(Request $request){
        favorite::find($request->id)->delete();
    }

    public function comment(Request $request){
        comment::create([
            
        ]);
    }

}