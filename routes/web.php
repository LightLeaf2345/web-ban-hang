<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\ExcelImportController;
use App\Models\Category;
use App\Models\Product;

/*
|--------------------------------------------------------------------------
| 1. Giao diện Xác thực (Auth)
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::get('/register', [LoginController::class, 'showRegisterForm']);
Route::post('/register', [LoginController::class, 'register']);
Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm']);
Route::post('/forgot-password', [LoginController::class, 'sendResetLinkEmail']);

/*
|--------------------------------------------------------------------------
| 2. Giao diện Khách hàng (Storefront)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index']);
Route::get('/cart', function () {
    return view('storefront.cart');
});
Route::get('/checkout', function () {
    return view('storefront.checkout');
});
Route::get('/order-success', function () {
    return view('storefront.order-success');
});
Route::get('/profile', [ProfileController::class, 'index'])->name('profile')->middleware('auth');
Route::post('/profile/update', [ProfileController::class, 'update'])->middleware('auth');
Route::post('/profile/wishlist/toggle/{productId}', [ProfileController::class, 'toggleWishlist'])->middleware('auth');
Route::post('/profile/order/cancel/{orderId}', [ProfileController::class, 'cancelOrder'])->middleware('auth');
Route::get('/flash-sale', function () {
    return view('storefront.flash-sale');
});

// Nhóm Sản phẩm (Đã trỏ vào thư mục con products)
Route::get('/products', function () {
    $products = Product::where('status', 'active')->with('category')->latest()->get();
    $categories = Category::where('status', 'active')->orderBy('name')->get();

    return view('storefront.products.index', compact('products', 'categories'));
});
Route::get('/products/{slug}', function ($slug) {
    return view('storefront.products.show');
});

// Nhóm Bộ sưu tập (Đã trỏ vào thư mục con collections)
Route::view('/collections', 'storefront.collections.index');
Route::get('/collections/{slug}', function ($slug) {
    return view('storefront.collections.show'); 
});

/*
|--------------------------------------------------------------------------
| 3. Giao diện Quản trị (Admin Panel)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::view('/', 'admin.dashboard'); 
    Route::get('/products', [AdminProductController::class, 'index']);
    Route::post('/products', [AdminProductController::class, 'store']);
    Route::post('/products/import', [ExcelImportController::class, 'import']);
    Route::get('/products/import/sample', [ExcelImportController::class, 'downloadSample']);
    Route::post('/products/{id}', [AdminProductController::class, 'update']);
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy']);
    Route::get('/categories', [AdminCategoryController::class, 'index']);
    Route::post('/categories', [AdminCategoryController::class, 'store']);
    Route::put('/categories/{id}', [AdminCategoryController::class, 'update']);
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy']);
    Route::view('/orders', 'admin.orders');
    Route::view('/promotions', 'admin.promotions');
    Route::view('/customers', 'admin.customers');
    
});
