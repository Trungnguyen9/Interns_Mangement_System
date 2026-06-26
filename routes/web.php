<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\InternManagementController;
use App\Http\Middleware\CheckAdminRole;


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('adminpage')
    ->middleware(['auth', CheckAdminRole::class])
    ->group(function () {
        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('admin.index');

        // Accounts & Roles
        Route::get('/account', [AccountController::class, 'index'])->name('admin.account.index');
        // add
        Route::get('/account/create', [AccountController::class, 'create'])->name('admin.account.add');
        Route::post('/account/create', [AccountController::class, 'store']);
        // edit
        Route::get('/account/edit/{id}', [AccountController::class, 'edit'])->name('admin.account.edit');
        Route::post('/account/edit/{id}', [AccountController::class, 'update']);
        // delete
        Route::delete('/account/{id}', [AccountController::class, 'destroy'])->name('admin.account.destroy');

        // Interns Management
        Route::get('/intern', [InternManagementController::class, 'index'])->name('admin.intern.index');
        // add
        Route::get('/intern/create', [InternManagementController::class, 'create'])->name('admin.intern.create');
        Route::post('/intern/create', [InternManagementController::class, 'store']);
        // edit
        Route::get('/intern/edit/{id}', [InternManagementController::class, 'edit'])->name('admin.intern.edit');
        Route::post('/intern/edit/{id}', [InternManagementController::class, 'update']);
        // show
        Route::get('/intern/show/{id}', [InternManagementController::class, 'show'])->name('admin.intern.show');
        // delete
        Route::delete('/intern/{id}', [InternManagementController::class, 'destroy'])->name('admin.intern.destroy');
    });
