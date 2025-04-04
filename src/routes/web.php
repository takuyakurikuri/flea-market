<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
//use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\StripeController;

Route::post('/register',[AuthController::class,'store']);
Route::post('/login',[AuthController::class,'login']);
Route::get('/email/verify',[AuthController::class,'mailVerify'])->name('verification.notice');
Route::post('/email/verification-notification', [AuthController::class,'resendEmail'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');//メールの再送
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware('signed')->name('verification.verify');

Route::middleware('auth','verified')->group(function(){
    Route::get('/sell',[ItemController::class,'sellRegister']);
    Route::get('/mypage',[AuthController::class,'mypage']);
    Route::get('/mypage/profile',[AuthController::class,'profile']);
    Route::post('/item/{item_id}/comment',[ItemController::class,'addComment']);
    Route::get('/item/{item_id}/purchase',[PurchaseController::class,'purchase'])->name('item.purchase');
    //Route::post('/item/{item_id}/purchase',[PurchaseController::class,'buy']);
    Route::get('/purchase/address/{item_id}',[PurchaseController::class,'formAddress']);
    Route::post('/purchase/address/{item_id}',[PurchaseController::class,'changeAddress'])->name('address.change');
    Route::post('/item/{item_id}/checkout',[StripeController::class,'checkout']);
    Route::get('/success', [StripeController::class, 'success'])->name('checkout.success');
    Route::get('/cancel', [StripeController::class, 'cancel'])->name('checkout.cancel');
    Route::post('/mypage/profile',[AuthController::class,'profileRegister']);
    Route::patch('/mypage/profile',[AuthController::class,'modifyProfile']);
});

Route::get('/',[ItemController::class, 'index']);
Route::get('/search',[ItemController::class, 'search']);
route::post('/sell',[ItemController::class,'sell']);

Route::prefix('/item/{item_id}')->group(function(){
    Route::get('',[ItemController::class,'itemDetail'])->name('item.detail');
    Route::delete('',[ItemController::class,'destroyFavorite']);
    Route::post('',[ItemController::class,'addFavorite']);
});