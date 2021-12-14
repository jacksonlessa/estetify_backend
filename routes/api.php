<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\AccountController;

use App\Http\Controllers\OrderController;

// RESUME AND REPORT
use App\Http\Controllers\DashboardController;
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
Route::put('/auth/recover-password',
        [AuthController::class, 'recoverPassword']
    )->name('auth.recover-password');
Route::put('/auth/reset-password',
    [AuthController::class, 'resetPassword']
)->name('auth.reset-password');

// ## Protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    // Logout
    Route::post('logout', [AuthController::class, 'logout']);

    
    // Restore Routes
    Route::put('services/{id}/restore', [ServiceController::class, 'restore'])
        ->name('services.restore');
    Route::put('clients/{id}/restore', [ClientController::class, 'restore'])
        ->name('clients.restore');
    Route::put('professionals/{id}/restore', [ProfessionalController::class, 'restore'])
        ->name('professionals.restore');
    Route::put('users/{id}/restore', [UserController::class, 'restore'])
        ->name('users.restore');



    Route::post('accounts/plan', [AccountController::class, 'storePlan'])
        ->name('accounts.plan');
    
    // Resources
    Route::apiResources([
        'services' => ServiceController::class,
        'accounts' => AccountController::class,
        'clients' => ClientController::class,
        'professionals' => ProfessionalController::class,
        'users' => UserController::class,
        'orders' => OrderController::class,
    ]);

    // Professionals
    Route::get('professionals/', [ProfessionalController::class, 'index'])
        ->name('professionals.index');
    Route::get('professionals/{id}', [ProfessionalController::class, 'show'])
        ->name('professionals.show');
    
    

    // Route::get('/professionals/{professional}/schedule/', [ScheduleController::class, 'index'])
    //     ->name('professionals.schedule.index');

    Route::get(
        '/user/profile',
        [UserProfileController::class, 'show']
    )->name('profile');
    Route::put(
        '/user/profile',
        [UserProfileController::class, 'update']
    )->name('profile.edit');


    // REPORTS
    Route::get('dashboard/', [DashboardController::class, 'index'])
        ->name('dashboard.index');
});
