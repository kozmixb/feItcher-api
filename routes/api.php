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

Route::post('login', [\App\Http\Controllers\LoginController::class, 'login']);
Route::group([
    'prefix' => 'products',
    // 'middleware' => ['auth:api']
], function () {
    Route::get('/', [\App\Http\Controllers\ProductController::class, 'index']);
    Route::get('{productId}', [\App\Http\Controllers\ProductController::class, 'show']);
});
