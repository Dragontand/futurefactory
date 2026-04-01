<?php

use App\Enums\UserRole;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // profile
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    Route::middleware('role:admin,buyer')->group(function () {
        Route::get('modules/cancel', [ModuleController::class, 'cancel'])
            ->name('modules.cancel');
        Route::post('modules/type', [ModuleController::class, 'storeType'])
            ->name('modules.storeType');

        Route::resource('modules', ModuleController::class);
    });

    Route::middleware('role:admin,mechanic')->group(function () {
        Route::resource('vehicles', VehicleController::class);
    });
});



require __DIR__.'/auth.php';
