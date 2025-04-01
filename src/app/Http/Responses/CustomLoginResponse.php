<?php

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = auth()->user();

        
        if (!$user->address) {
            return redirect('/mypage/profile'); // 適切なルートを指定
        }

        return redirect()->intended(config('fortify.home'));
    }
}