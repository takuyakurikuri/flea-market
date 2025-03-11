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
        'item_name' => $request['item_name'],
        'item_brand' => $request['item_brand'],
        'item_detail' => $request['item_detail'],
        'item_price' => $request['item_price']
        ]);

        return redirect('/')->with('success','商品の出品に成功しました');
    }

    public function itemDetail($item_id) {
        $item = Item::withCount('favorites')->find($item_id);
        $comments_count = Item::withCount('comments')->find($item_id);
        $comments = Comment::with(['user.profile'])->where('item_id',$item_id)->get();
        $isFavorite = Auth::check() ? favorite::where('item_id',$item_id)->where('user_id',Auth::id())->exists() : false;

        return view('detail',compact('item','isFavorite','comments','comments_count'));
    }

    public function addFavorite(Request $request){
        Favorite::create([
            'user_id' => Auth::id(),
            'item_id' => $request->item_id
        ]);

        return redirect()->route('item.detail', ['item_id' => $request->item_id])->with('message','お気に入り登録をしました');
    }

    public function destroyFavorite(Request $request){
        $isFavorite =favorite::where('item_id',$request->item_id)->where('user_id',Auth::id())->first();

        if($isFavorite) {
            $isFavorite->delete();
            return redirect()->route('item.detail', ['item_id' => $request->item_id])->with('message','お気に入りを解除しました');
        }

        return redirect()->route('item.detail', ['item_id' => $request->item_id])->with('message','お気に入りが見つかりませんでした');
    }

    public function addComment(Request $request){
        comment::create([
            'user_id' => Auth::id(),
            'item_id' => $request->item_id,
            'content' =>$request->comment
        ]);

        return redirect()->route('item.detail', ['item_id' => $request->item_id])->with('message','コメントを送信しました');
    }

}