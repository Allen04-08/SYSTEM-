<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProductController,
    RawMaterialController,
    StockMovementController,
    CustomerController,
    SalesOrderController,
    OrderItemController,
    ProductionOrderController,
    ProductionStageController,
    ProductionReportController,
    FeedbackController,
    AuthController
};

// Public endpoints
Route::middleware(['sanctum.stateful', 'throttle:60,1'])->group(function () {
    Route::get('/health', fn () => response()->json(['status' => 'ok']));
    Route::post('/auth/login', [AuthController::class, 'login']);
});

// Authenticated routes
Route::middleware(['auth:sanctum', 'secure.headers', 'throttle:120,1'])->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Admin/Staff
    Route::middleware(['role:Admin|Staff'])->group(function () {
        Route::apiResource('products', ProductController::class);
        Route::apiResource('materials', RawMaterialController::class);
        Route::apiResource('stock-movements', StockMovementController::class)->only(['index','store','show']);
        Route::apiResource('production-orders', ProductionOrderController::class);
        Route::apiResource('production-stages', ProductionStageController::class);
        Route::apiResource('production-reports', ProductionReportController::class)->only(['index','store','show']);
        Route::apiResource('customers', CustomerController::class)->only(['index','show','update']);
        Route::apiResource('sales-orders', SalesOrderController::class);
        Route::apiResource('order-items', OrderItemController::class);
    });

    // Customer
    Route::middleware(['role:Customer'])->group(function () {
        Route::get('products', [ProductController::class, 'index']);
        Route::get('products/{product}', [ProductController::class, 'show']);
        Route::apiResource('sales-orders', SalesOrderController::class)->only(['index','store','show']);
        Route::apiResource('feedback', FeedbackController::class)->only(['index','store','show']);
    });
});