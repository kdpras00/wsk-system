<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::get('/register', [\App\Http\Controllers\AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
});

Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('yarns', \App\Http\Controllers\YarnMaterialController::class);
    Route::resource('production', \App\Http\Controllers\ProductionController::class);
    Route::patch('/production/{id}/status', [\App\Http\Controllers\ProductionController::class, 'updateStatus'])->name('production.update-status');
    
    // Daily Production Reports (Digitization)
    Route::resource('daily-reports', \App\Http\Controllers\ProductionReportController::class);

    // Admin Routes
    Route::middleware(['auth'])->prefix('admin')->group(function () {
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::get('/reports', function () {
            // Placeholder for report logic, ideally should be a controller method
            $productions = \App\Models\ProductionOrder::with('manager')->latest()->get();
            return view('admin.reports.index', compact('productions'));
        })->name('admin.reports.index');
    });
});
