<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Models\Profile;
use App\Models\User;

class ProfileController extends Controller
{
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
}