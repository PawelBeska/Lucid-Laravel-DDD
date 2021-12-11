<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/link', [\App\Http\Controllers\LinkController::class, 'store'])->name('link.store');

Route::middleware('guest')->prefix('auth')->name('auth.')->group(function () {
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
