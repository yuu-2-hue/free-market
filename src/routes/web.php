<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListController;
use App\Http\Controllers\DetailController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SellController;

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

Route::middleware('verified')->group(function () {
    // プロフィール編集画面
    Route::get('/mypage/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::post('/mypage/profile', [ProfileController::class, 'store']);

    // いいね
    Route::post('/item/{item_id}/favorite', [DetailController::class, 'addFavorite']);
    // コメント送信
    Route::post('/item/{item_id}/comment', [DetailController::class, 'addComment']);

    // 購入処理
    Route::post('/purchase/{item_id}/checkout', [PurchaseController::class, 'store']);

    Route::middleware('register')->group(function(){
        // 購入画面
        Route::get('/purchase/{item_id}', [PurchaseController::class, 'purchase'])->name('purchase');

        // 住所変更画面
        Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'address'])->name('address');
        Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'edit']);

        // 出品画面
        Route::get('/sell', [SellController::class, 'sell'])->name('sell');
        Route::post('/sell', [SellController::class, 'exhibit']);

        // マイページ画面
        Route::get('/mypage', [ProfileController::class, 'mypage'])->name('mypage');
    });
});

// 商品一覧画面
Route::get('/', [ListController::class, 'index'])->name('index');
Route::post('/', [ListController::class, 'search'])->name('search');

// 商品詳細画面
Route::get('/item/{item_id}', [DetailController::class, 'detail'])->name('detail');

