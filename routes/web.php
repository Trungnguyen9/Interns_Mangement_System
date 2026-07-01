<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\InternManagementController;
use App\Http\Controllers\Admin\MentorManagementController;
use App\Http\Controllers\Frontend\DashboardController as FrontendDashboardController;
use App\Http\Controllers\Frontend\ProfilesController;
use App\Http\Controllers\Frontend\TaskController;
use App\Http\Middleware\CheckAdminRole;
use App\Http\Middleware\CheckInternRole;

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

        // Mentor Management
        Route::get('/mentor', [MentorManagementController::class, 'index'])->name('admin.mentor.index');
        // add
        Route::get('/mentor/create', [MentorManagementController::class, 'create'])->name('admin.mentor.create');
        Route::post('/mentor/create', [MentorManagementController::class, 'store']);
        // edit
        Route::get('/mentor/edit/{id}', [MentorManagementController::class, 'edit'])->name('admin.mentor.edit');
        Route::post('/mentor/edit/{id}', [MentorManagementController::class, 'update']);
        // show
        Route::get('/mentor/show/{id}', [MentorManagementController::class, 'show'])->name('admin.mentor.show');
        // delete
        Route::delete('/mentor/{id}', [MentorManagementController::class, 'destroy'])->name('admin.mentor.destroy');
    });

Route::prefix('internpage')->middleware(['auth', CheckInternRole::class])->group(function () {
    // Dashboard
    Route::get('/dashboard', [FrontendDashboardController::class, 'index'])->name('frontend.intern');

    // Profiles
    Route::get('/profile', [ProfilesController::class, 'index'])->name('frontend.profile.index');
    //edit
    Route::get('/profile/edit/{id}', [ProfilesController::class, 'edit'])->name('frontend.intern.profile.edit');
    Route::post('/profile/edit/{id}', [ProfilesController::class, 'update']);

    // Tasks
    Route::get('/tasks', [TaskController::class, 'index'])->name('frontend.intern.tasks');
    //edit
    Route::get('/tasks/edit/{id}', [TaskController::class, 'edit'])->name('frontend.intern.tasks.edit');
    Route::post('/tasks/edit/{id}', [TaskController::class, 'update'])->name('frontend.intern.tasks.update');
});
