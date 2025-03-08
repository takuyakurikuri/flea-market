<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/register',[AuthController::class,'store']);

Route::post('/login',[AuthController::class,'login']);

Route::middleware('auth')->group(function(){
    Route::get('/sell',[ItemController::class,'sellRegister']);
    Route::get('/mypage',[AuthController::class,'mypage']);
    Route::get('/mypage/profile',[AuthController::class,'profile']);
});

Route::get('/',[ItemController::class, 'index']);

route::post('/sell',[ItemController::class,'sell']);

Route::post('/mypage/profile',[AuthController::class,'profileRegister']);

Route::get('/item/{item_id}',[ItemController::class,'itemDetail']);

Route::post('/item/{item_id}',[ItemController::class,'addFavorite']);

Route::delete('/item/{item_id}',[ItemController::class,'destroyFavorite']);