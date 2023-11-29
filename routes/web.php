<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();
Route::get('/admin/login', [App\Http\Controllers\Auth\LoginController::class, 'showAdminLoginForm']);

Route::middleware(['web','auth','checkRole:user'])->group(function () {
Route::get('/', [App\Http\Controllers\UserController::class, 'index']);
Route::get('/home', [App\Http\Controllers\UserController::class, 'index'])->name('home');
});

Route::middleware(['web','auth','checkRole:admin'])->prefix('admin')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index']);
    Route::get('/index', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
});