<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AdminOrderController;
use App\Http\Controllers\Api\AdminReportController;
use App\Http\Controllers\Api\AdminUserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerOrderController;
use App\Http\Controllers\Api\PaymentProofController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SellerOrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/users', [AdminUserController::class, 'index']);
        Route::post('/users', [AdminUserController::class, 'store']);
        Route::patch('/users/{user}/role', [AdminUserController::class, 'updateRole']);

        Route::get('/categories', [CategoryController::class, 'adminIndex']);
        Route::post('/categories', [CategoryController::class, 'store']);
        Route::patch('/categories/{category}', [CategoryController::class, 'update']);
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

        Route::get('/orders', [AdminOrderController::class, 'index']);
        Route::get('/orders/{order}', [AdminOrderController::class, 'show']);

        Route::get('/reports/sales', [AdminReportController::class, 'sales']);
    });

    Route::middleware('role:seller')->prefix('seller')->group(function () {
        Route::get('/products', [ProductController::class, 'sellerIndex']);
        Route::post('/products', [ProductController::class, 'store']);
        Route::patch('/products/{product}', [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);

        Route::get('/orders', [SellerOrderController::class, 'index']);
        Route::patch('/orders/{order}/status', [SellerOrderController::class, 'updateStatus']);
    });

    Route::middleware('role:customer')->prefix('customer')->group(function () {
        Route::get('/orders', [CustomerOrderController::class, 'index']);
        Route::get('/orders/{order}', [CustomerOrderController::class, 'show']);
        Route::post('/orders', [CustomerOrderController::class, 'store']);
        Route::post('/orders/{order}/payment-proof', [PaymentProofController::class, 'store']);
    });
});
