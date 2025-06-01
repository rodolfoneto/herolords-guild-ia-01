<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\RoleController;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    // Admin Routes for Roles
    Route::prefix('admin')->name('admin.')->group(function () {
        // You might want to add an admin-specific middleware here, e.g., ->middleware('is_admin')
        Route::resource('roles', RoleController::class);
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
