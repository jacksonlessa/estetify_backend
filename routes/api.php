<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\ServiceController;
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

// ## Public routes
// # Auth
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// ## Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    // Logout
    Route::post('logout', [AuthController::class, 'logout']);

    // Services
    Route::apiResources([
        'services' => ServiceController::class,
    ]);

    // Restore Routes
    Route::put('services/{id}/restore', [ServiceController::class, 'restore'])
        ->name('services.restore');

});

// Getting ative user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


