<?php

// デフォルト
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
// トップページ
use App\Http\Controllers\HomeController;
// オーナー関連
use App\Http\Controllers\Owner\OwnerShopController;

/**
 * ルーティング
 */

// トップページ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// オーナートップ
Route::get('/owner', function () {
    return view('owner.index');
})->middleware(['auth', 'verified'])->name('owner.index');

// ショップ情報
Route::prefix('owner')->middleware('auth')->group(function () {
    // ショップ一覧を表示するルート
    Route::get('/shop', [OwnerShopController::class, 'index'])->name('owner.shop.index');
    // ショップ情報登録処理へのルート
    Route::post('/shop', [OwnerShopController::class, 'store'])->name('owner.shop.store');
    // ショップ情報登録画面へのルート
    Route::get('/shop/create', [OwnerShopController::class, 'create'])->name('owner.shop.create');
    // ショップ情報更新処理へのルート
    // Route::get('/shop/{id}', [OwnerShopController::class, 'edit'])->name('owner.shop.edit');
    // Route::put('/shop/{id}', [OwnerShopController::class, 'update'])->name('owner.shop.update');
    // Route::delete('/shop/{id}', [OwnerShopController::class, 'destroy'])->name('owner.shop.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
