<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\AdminLeaveRequestController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/dashboard', function () {
    return redirect()->route('employee.leave-requests.index');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware(['auth', 'verified'])->group(function () {

    // Employee routes
    Route::middleware(['can:request leave'])->group(function () {
        Route::resource('leave-requests', LeaveRequestController::class)
            ->except(['edit', 'update', 'destroy'])
            ->names([
                'index'  => 'employee.leave-requests.index',
                'create' => 'employee.leave-requests.create',
                'store'  => 'employee.leave-requests.store',
                'show'   => 'employee.leave-requests.show',
            ]);
    });

    // Admin routes
    Route::prefix('admin')->middleware(['can:approve leave'])->group(function () {
        Route::resource('leave-requests', AdminLeaveRequestController::class)
            ->only(['index', 'edit', 'update'])
            ->names([
                'index'  => 'admin.leave-requests.index',
                'edit'   => 'admin.leave-requests.edit',
                'update' => 'admin.leave-requests.update',

            ]);
    });

    // Report routes
    Route::prefix('reports')->middleware(['can:generate reports'])->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/generate', [ReportController::class, 'generate'])->name('reports.generate');
        Route::get('/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export-pdf');
        Route::get('/export-excel', [ReportController::class, 'exportExcel'])->name('reports.export-excel');
    });
});

Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login');
})->name('logout');



require __DIR__ . '/auth.php';
