<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\RegisterResponse;
use App\Actions\Auth\CustomAttemptToAuthenticate;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
            public function toResponse($request)
            {
                return redirect('/mypage/profile');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        //Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);

        //RateLimiter::for('two-factor', function (Request $request) {
        //    return Limit::perMinute(5)->by($request->session()->get('login.id'));
        //});

        Fortify::authenticateThrough(function ($request) {
        return array_filter([
            CustomAttemptToAuthenticate::class, // カスタム認証クラス
        ]);
    });

        Fortify::registerView(function(){
            return view('auth.register');
        });
        Fortify::loginView(function(){
            return view('auth.login');
        });
    }
}