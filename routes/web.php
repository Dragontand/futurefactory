<?php

use App\Enums\UserRole;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
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
        Route::controller(ModuleController::class)->group(function () {
            Route::get('modules/cancel', 'cancel')
                ->name('modules.cancel');

            Route::post('modules/type', 'storeType')
                ->name('modules.storeType');

            Route::resource('modules', ModuleController::class);
        });
    });

    Route::middleware('role:admin,mechanic')->group(function () {
        Route::post('vehicles/create-step2', [VehicleController::class, 'createStep2'])
            ->name('vehicles.create-step2');

        Route::resource('vehicles', VehicleController::class)
            ->except(['edit', 'update']);;
    });

    Route::middleware('role:admin,schedular')->group(function () {
        Route::get('schedules/day/{date}', [ScheduleController::class, 'show'])
            ->name('schedules.show');

        Route::resource('schedules', ScheduleController::class)
            ->except(['edit', 'update', 'show']);;
    });
});



require __DIR__.'/auth.php';
