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
    Route::get('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::get('/notifications/count', [\App\Http\Controllers\NotificationController::class, 'count'])->name('notifications.count');
    
    Route::resource('yarns', \App\Http\Controllers\YarnMaterialController::class);
    Route::resource('fabrics', \App\Http\Controllers\FabricController::class);
    Route::resource('production', \App\Http\Controllers\ProductionController::class);
    Route::patch('/production/{id}/status', [\App\Http\Controllers\ProductionController::class, 'updateStatus'])->name('production.update-status');
    
    // Daily Production Reports (Digitization)
    Route::get('daily-reports/monthly-yarn-usage', [\App\Http\Controllers\ProductionReportController::class, 'monthlyYarnUsage'])->name('daily-reports.monthly_yarn_usage');
    Route::get('daily-reports/export-details', [\App\Http\Controllers\ProductionReportController::class, 'exportDetails'])->name('daily-reports.export_details');
    Route::get('daily-reports/export-summary', [\App\Http\Controllers\ProductionReportController::class, 'exportSummary'])->name('daily-reports.export_summary');
    Route::patch('daily-reports/{productionReport}/approve', [\App\Http\Controllers\ProductionReportController::class, 'approve'])->name('daily-reports.approve');
    Route::patch('daily-reports/{productionReport}/reject', [\App\Http\Controllers\ProductionReportController::class, 'reject'])->name('daily-reports.reject');
    Route::resource('daily-reports', \App\Http\Controllers\ProductionReportController::class);
    Route::resource('instructions', \App\Http\Controllers\InstructionController::class);

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
