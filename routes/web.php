<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group([
    'prefix' => 'admin'
    ], function () {
    // Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
});


