<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\MyReviewController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminMemberController;
use App\Http\Controllers\AdminProductCategoryController;
use App\Http\Controllers\AdminProductController;

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
Route::get('/member/password/reset', [PasswordResetController::class, 'showResetRequestForm'])
    ->name('member.password.request');

Route::post('/member/password/email', [PasswordResetController::class, 'sendResetLinkEmail'])
    ->name('member.password.email');

Route::get('/member/password/reset/sent', [PasswordResetController::class, 'showResetSent'])
    ->name('member.password.sent');

Route::get('/member/password/reset/form', [PasswordResetController::class, 'showResetForm'])
    ->name('member.password.reset.form');

Route::post('/member/password/reset', [PasswordResetController::class, 'resetPassword'])
    ->name('member.password.update');

// 商品一覧（認証不要）
Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

// 商品登録関連（認証必須）
Route::middleware('auth:member')->group(function () {
    Route::get('/products/create', [ProductController::class, 'create'])
        ->name('products.create');
    
    Route::post('/products/confirm', [ProductController::class, 'confirm'])
        ->name('products.confirm');
    
    Route::post('/products/back', [ProductController::class, 'back'])
        ->name('products.back');
    
    Route::post('/products/store', [ProductController::class, 'store'])
        ->name('products.store');
    
    Route::get('/products/subcategories/{category_id}', [ProductController::class, 'getSubcategories'])
        ->name('products.subcategories');
    
    Route::post('/products/upload-image', [ProductController::class, 'uploadImage'])
        ->name('products.upload.image');
    
    // マイページ
    Route::get('/mypage', [MypageController::class, 'index'])
        ->name('mypage');
    
    // 会員情報変更
    Route::get('/profile/edit', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::post('/profile/confirm', [ProfileController::class, 'confirm'])
        ->name('profile.confirm');

    Route::post('/profile/back', [ProfileController::class, 'back'])
        ->name('profile.back');

    Route::post('/profile/update', [ProfileController::class, 'update'])
        ->name('profile.update');
    
    // パスワード変更
    Route::get('/password/edit', [PasswordController::class, 'edit'])
        ->name('password.edit');

    Route::post('/password/update', [PasswordController::class, 'update'])
        ->name('password.update');
    
    // メールアドレス変更
    Route::get('/email/edit', [EmailController::class, 'edit'])
        ->name('email.edit');

    Route::post('/email/send', [EmailController::class, 'send'])
        ->name('email.send');

    Route::get('/email/verify', [EmailController::class, 'verify'])
        ->name('email.verify');

    Route::post('/email/complete', [EmailController::class, 'complete'])
        ->name('email.complete');

    // 退会
    Route::get('/withdraw', [MypageController::class, 'showWithdraw'])
        ->name('withdraw');

    Route::post('/withdraw', [MypageController::class, 'withdraw'])
        ->name('withdraw.post');   
});

// 商品詳細
Route::get('/products/{id}', [ProductController::class, 'show'])
    ->name('products.show');

// 商品レビュー一覧(認証不要)
Route::get('/products/{product_id}/reviews', [ReviewController::class, 'index'])
    ->name('reviews.index');

// 商品レビュー関連(認証必須)
Route::middleware('auth:member')->group(function () {
    Route::get('/products/{product_id}/reviews/create', [ReviewController::class, 'create'])
        ->name('reviews.create');
    
    Route::post('/products/{product_id}/reviews/confirm', [ReviewController::class, 'confirm'])
        ->name('reviews.confirm');
    
    Route::post('/products/{product_id}/reviews/back', [ReviewController::class, 'back'])
        ->name('reviews.back');
    
    Route::post('/products/{product_id}/reviews/store', [ReviewController::class, 'store'])
        ->name('reviews.store');
    
    Route::get('/products/{product_id}/reviews/complete', [ReviewController::class, 'complete'])
        ->name('reviews.complete');
    
    Route::get('/my-reviews', [MyReviewController::class, 'index'])
        ->name('my-reviews');

    Route::get('/my-reviews/{id}/edit', [MyReviewController::class, 'edit'])
        ->name('my-reviews.edit');

    Route::post('/my-reviews/{id}/confirm', [MyReviewController::class, 'confirm'])
        ->name('my-reviews.confirm');

    Route::post('/my-reviews/{id}/back', [MyReviewController::class, 'back'])
        ->name('my-reviews.back');

    Route::post('/my-reviews/{id}/update', [MyReviewController::class, 'update'])
        ->name('my-reviews.update');

    Route::get('/my-reviews/{id}/delete', [MyReviewController::class, 'delete'])
        ->name('my-reviews.delete');

    Route::delete('/my-reviews/{id}', [MyReviewController::class, 'destroy'])
        ->name('my-reviews.destroy');
});

// 管理者関連ルート
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])
        ->name('login');
    Route::post('/login', [AdminController::class, 'login'])
        ->name('login.post');
    Route::get('/top', [AdminController::class, 'top'])
        ->name('top');
    Route::post('/logout', [AdminController::class, 'logout'])
        ->name('logout');

    // 会員一覧
    Route::get('/members', [AdminMemberController::class, 'index'])
        ->name('members.index');

    // 会員登録
    Route::get('/members/create', [AdminMemberController::class, 'create'])
        ->name('members.create');

    // 会員詳細（追加）
    Route::get('/members/{id}', [AdminMemberController::class, 'show'])
        ->name('members.show');
    
    // 会員編集
    Route::get('/members/{id}/edit', [AdminMemberController::class, 'edit'])
        ->name('members.edit');
    
    // 確認画面
    Route::post('/members/confirm', [AdminMemberController::class, 'confirm'])
        ->name('members.confirm');
    
    Route::post('/members/back', [AdminMemberController::class, 'back'])
        ->name('members.back');
    
    Route::post('/members/store', [AdminMemberController::class, 'store'])
        ->name('members.store');
    
    Route::post('/members/update', [AdminMemberController::class, 'update'])
        ->name('members.update');

    Route::delete('/members/{id}', [AdminMemberController::class, 'destroy'])
        ->name('members.destroy');

    // 商品カテゴリ関連
    Route::get('/product-categories', [AdminProductCategoryController::class, 'index'])
        ->name('product_categories.index');
    
    Route::get('/product-categories/create', [AdminProductCategoryController::class, 'create'])
        ->name('product_categories.create');
    
    Route::get('/product-categories/{id}/edit', [AdminProductCategoryController::class, 'edit'])
        ->name('product_categories.edit');

    Route::post('/product-categories/confirm', [AdminProductCategoryController::class, 'confirm'])
        ->name('product_categories.confirm');

    Route::post('/product-categories/back', [AdminProductCategoryController::class, 'back'])
        ->name('product_categories.back');

    Route::post('/product-categories/store', [AdminProductCategoryController::class, 'store'])
        ->name('product_categories.store');

    Route::post('/product-categories/update', [AdminProductCategoryController::class, 'update'])
        ->name('product_categories.update');

    // 商品カテゴリ詳細
    Route::get('/product-categories/{id}', [AdminProductCategoryController::class, 'show'])
        ->name('product_categories.show');

    // 商品カテゴリ削除
    Route::delete('/product-categories/{id}', [AdminProductCategoryController::class, 'destroy'])
        ->name('product_categories.destroy');

    // 商品一覧
    Route::get('/products', [AdminProductController::class, 'index'])
        ->name('products.index');

    // 商品関連
    Route::get('/products', [AdminProductController::class, 'index'])
        ->name('products.index');

    Route::get('/products/create', [AdminProductController::class, 'create'])
        ->name('products.create');

    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])
        ->name('products.edit');

    Route::post('/products/confirm', [AdminProductController::class, 'confirm'])
        ->name('products.confirm');
    
    Route::post('/products/back', [AdminProductController::class, 'back'])
        ->name('products.back');

    Route::post('/products/store', [AdminProductController::class, 'store'])
        ->name('products.store');

    Route::post('/products/update', [AdminProductController::class, 'update'])
        ->name('products.update');

    Route::get('/products/subcategories/{categoryId}', [AdminProductController::class, 'getSubcategories'])
        ->name('products.subcategories');

    Route::post('/products/upload', [AdminProductController::class, 'uploadImage'])
        ->name('products.upload');
});