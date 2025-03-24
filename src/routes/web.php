<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProfileController;

Route::post('/register',[AuthController::class,'store']);
Route::post('/login',[AuthController::class,'login']);

Route::middleware('auth')->group(function(){
    Route::get('/sell',[ItemController::class,'sellRegister']);
    Route::get('/mypage',[AuthController::class,'mypage']);
    //Route::get('/mypage/profile',[AuthController::class,'profile']);
    Route::get('/mypage/profile',[ProfileController::class,'profile']);
    Route::post('/item/{item_id}/comment',[ItemController::class,'addComment']);
    Route::get('/item/{item_id}/purchase',[PurchaseController::class,'purchase'])->name('item.purchase');
    Route::post('/item/{item_id}/purchase',[PurchaseController::class,'buy']);
    Route::get('/purchase/address/{item_id}',[PurchaseController::class,'formAddress']);
    Route::post('/purchase/address/{item_id}',[PurchaseController::class,'changeAddress']);
});

Route::get('/',[ItemController::class, 'index']);
Route::get('/search',[ItemController::class, 'search']);
route::post('/sell',[ItemController::class,'sell']);
//Route::post('/mypage/profile',[AuthController::class,'profileRegister']);
Route::post('/mypage/profile',[ProfileController::class,'profileRegister']);
//Route::patch('/mypage/profile',[AuthController::class,'modifyProfile']);
Route::patch('/mypage/profile',[ProfileController::class,'modifyProfile']);

Route::prefix('/item/{item_id}')->group(function(){
    Route::get('',[ItemController::class,'itemDetail'])->name('item.detail');
    Route::delete('',[ItemController::class,'destroyFavorite']);
    Route::post('',[ItemController::class,'addFavorite']);
});