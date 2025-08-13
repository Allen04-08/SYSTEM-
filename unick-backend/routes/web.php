<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json(['app' => config('app.name'), 'status' => 'ok']);
});

// CSRF cookie for Sanctum SPA
Route::get('/csrf-cookie', function () {
    return response()->noContent();
})->name('csrf-cookie');
