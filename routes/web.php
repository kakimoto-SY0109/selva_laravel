<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MyPageController;

// トップページ
Route::get('/member/top', [AuthController::class, 'top'])
    ->name('top');

// ログイン関連
Route::get('/member/login', [AuthController::class, 'showLogin'])
    ->name('login');
Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');
Route::post('/member/logout', [AuthController::class, 'logout'])
    ->name('logout');

// 会員登録フォーム表示
Route::get('/member/register', [MemberController::class, 'showRegisterForm'])
    ->name('member.register');

// 確認画面表示
Route::post('/member/confirm', [MemberController::class, 'showConfirm'])
    ->name('member.confirm');

// 登録フォームに戻る
Route::match(['GET', 'POST'], '/member/back', [MemberController::class, 'backToForm'])
    ->name('member.back');

// 登録処理実行
Route::post('/member/complete', [MemberController::class, 'register'])
    ->name('member.complete');

// パスワードリセット関連
// リセット申請フォーム表示
Route::get('/member/password/reset', [PasswordResetController::class, 'showResetRequestForm'])
    ->name('member.password.request');

// リセットメール送信処理
Route::post('/member/password/email', [PasswordResetController::class, 'sendResetLinkEmail'])
    ->name('member.password.email');

// メール送信完了画面
Route::get('/member/password/reset/sent', [PasswordResetController::class, 'showResetSent'])
    ->name('member.password.sent');

// パスワード再設定フォーム表示
Route::get('/member/password/reset/form', [PasswordResetController::class, 'showResetForm'])
    ->name('member.password.reset.form');

// パスワード更新処理
Route::post('/member/password/reset', [PasswordResetController::class, 'resetPassword'])
    ->name('member.password.update');

// 商品登録関連（認証必須）
Route::middleware('auth:member')->group(function () {
    // 商品登録フォーム表示
    Route::get('/products/create', [ProductController::class, 'create'])
        ->name('products.create');
    
    // 商品登録確認画面表示
    Route::post('/products/confirm', [ProductController::class, 'confirm'])
        ->name('products.confirm');
    
    // 商品登録フォームに戻る
    Route::post('/products/back', [ProductController::class, 'back'])
        ->name('products.back');
    
    // 商品登録処理
    Route::post('/products/store', [ProductController::class, 'store'])
        ->name('products.store');
    
    // Ajax: サブカテゴリ取得
    Route::get('/products/subcategories/{category_id}', [ProductController::class, 'getSubcategories'])
        ->name('products.subcategories');
    
    // Ajax: 画像アップロード
    Route::post('/products/upload-image', [ProductController::class, 'uploadImage'])
        ->name('products.upload.image');
});

Route::middleware('auth:member')->group(function () {
    Route::get('/mypage', [MypageController::class, 'index'])->name('mypage');
    Route::post('/logout', [MypageController::class, 'logout'])->name('logout');
});