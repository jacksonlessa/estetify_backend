<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\ScheduleController;
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
        'professionals' => ProfessionalController::class,
        'clients' => ClientController::class,
        'users' => UserController::class,        
        'schedules' => ScheduleController::class,
    ]);

    // Restore Routes
    Route::put('services/{id}/restore', [ServiceController::class, 'restore'])
        ->name('services.restore');
    Route::put('professionals/{id}/restore', [ProfessionalController::class, 'restore'])
        ->name('professionals.restore');
    Route::put('clients/{id}/restore', [ClientController::class, 'restore'])
        ->name('clients.restore');
    Route::put('users/{id}/restore', [UserController::class, 'restore'])
        ->name('users.restore');


    // Route::get('/professionals/{professional}/schedule/', [ScheduleController::class, 'index'])
    //     ->name('professionals.schedule.index');
});

// Getting ative user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


