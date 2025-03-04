<?php

namespace App\Actions\Auth;

use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\AttemptToAuthenticate;
use Laravel\Fortify\Fortify;

class CustomAttemptToAuthenticate extends AttemptToAuthenticate
{
    public function handle($request, $next)
    {
        if (Fortify::$authenticateUsingCallback) {
            return $this->handleUsingCustomCallback($request, $next);
        }

        if ($this->guard->attempt(
            $request->only(Fortify::username(), 'password'),
            $request->boolean('remember'))
        ) {
            return $next($request);
        }

        // 認証に失敗した場合、バリデーションエラーを返す
            throw ValidationException::withMessages([
                Fortify::username() => ['ログイン情報が登録されていません'],
            ]);

        $this->throwFailedAuthenticationException($request);
    }
}