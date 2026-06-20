<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

// Endpoint test sederhana
Route::get('test', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'OK',
        'timestamp' => now()->toDateTimeString()
    ]);
});

// Endpoint untuk mendapatkan daftar produk
Route::get('products', [ProductController::class, 'index']);

// Endpoint untuk mendapatkan detail produk
Route::get('products/{id}', [ProductController::class, 'show']);

// Endpoint untuk menambah produk
Route::post('products', [ProductController::class, 'store']);