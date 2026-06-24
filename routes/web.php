<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AccountController;
use App\Http\Middleware\CheckAdminRole;


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('adminpage')
    ->middleware(['auth', CheckAdminRole::class])
    ->group(function () {
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('admin.index');
        // Accounts & Roles
        Route::get('/account', [AccountController::class, 'index']);
            // add
        Route::get('/account/create', [AccountController::class, 'create'])->name('admin.account.add');
        Route::post('/account/create', [AccountController::class, 'store']);
            // edit
        Route::get('/account/edit/{id}', [AccountController::class, 'edit'])->name('admin.account.edit');
        Route::post('/account/edit/{id}', [AccountController::class, 'update']);
            // delete
        Route::delete('/account/{id}', [AccountController::class, 'destroy'])->name('admin.account.destroy');
    });
