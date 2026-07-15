<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\InternManagementController;
use App\Http\Controllers\Admin\MentorManagementController;
use App\Http\Controllers\Admin\ReportAdController;
use App\Http\Controllers\Admin\TaskAdController;
use App\Http\Controllers\Frontend\DashboardController as FrontendDashboardController;
use App\Http\Controllers\Frontend\ProfilesController;
use App\Http\Controllers\Frontend\ReportController;
use App\Http\Controllers\Frontend\TaskController;
use App\Http\Controllers\Mentor\IndexController;
use App\Http\Controllers\Mentor\InternMnController;
use App\Http\Controllers\Mentor\ReportMnController;
use App\Http\Controllers\Mentor\TaskMnController;
use App\Http\Middleware\CheckAdminRole;
use App\Http\Middleware\CheckInternRole;
use App\Http\Middleware\CheckMentorRole;

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

        // Tasks Management
        Route::get('/task', [TaskAdController::class, 'index'])->name('admin.tasks.index');

        // Reports Management
        Route::get('/report', [ReportAdController::class, 'index'])->name('admin.reports.index');
        // detail
        Route::get('/report/show/{id}', [ReportAdController::class, 'show'])->name('admin.reports.show');
        
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

    // Weekly Reports
    Route::get('reports', [ReportController::class, 'index'])->name('frontend.intern.reports');
    // add
    Route::post('reports/create', [ReportController::class, 'store'])->name('frontend.intern.reports.store');
});




Route::prefix('mentorpage')->middleware(['auth', CheckMentorRole::class])->group(function () {
    //Dashboard
    Route::get('/dashboard', [IndexController::class, 'index'])->name('frontend.mentor');

    //Interns Management
    Route::get('/interns', [InternMnController::class, 'index'])->name('frontend.mentor.interns');
    // Detail
    Route::get('/interns/show/{id}', [InternMnController::class, 'show'])->name('frontend.mentor.interns.show');

    //Tasks Management
    Route::get('/tasks', [TaskMnController::class, 'index'])->name('frontend.mentor.tasks');
    //Show task
    Route::get('/tasks/show/{id}', [TaskMnController::class, 'show'])->name('frontend.mentor.tasks.show');
    //Create
    Route::post('/tasks/create', [TaskMnController::class, 'store'])->name('frontend.mentor.tasks.store');
    //Edit
    Route::post('/tasks/edit/{id}', [TaskMnController::class, 'update'])->name('frontend.mentor.tasks.update');
    //Delete
    // Route::delete('/tasks/{id}', [TaskMnController::class, 'destroy'])->name('frontend.mentor.tasks.destroy');

    //Weekly Reports Management
    Route::get('/reports', [ReportMnController::class, 'index'])->name('frontend.mentor.reports');
    //Edit
    Route::post('/reports/edit/{id}', [ReportMnController::class, 'update'])->name('frontend.mentor.reports.update');
});
