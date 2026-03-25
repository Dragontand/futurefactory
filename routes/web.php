<?php

use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // profile
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    // Route::controller(ModuleController::class)->group(function () {
    //     Route::get('/modules', 'index')->name('module.index');

    //     Route::get('/modules/new', 'create')->name('module.create');
    //     Route::post('/modules', 'store')->name('module.store');

    //     Route::get('/modules/{module}', 'show')->name('module.show');

    //     Route::get('/modules/{module}/edit', 'edit')->name('module.edit');
    //     Route::patch('/modules/{module}', 'update')->name('module.update');

    //     Route::delete('/modules/{module}', 'destroy')->name('module.destroy');
    // });
    Route::resource('modules', ModuleController::class);
});



require __DIR__.'/auth.php';
