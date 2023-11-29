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
Route::post('/userGetOtp', [App\Http\Controllers\Auth\LoginController::class, 'userGetOtp'])->name('userGetOtp');
Route::post('/userVerifyOtp', [App\Http\Controllers\Auth\LoginController::class, 'userVerifyOtp'])->name('userVerifyOtp');
Route::get('/otp', [App\Http\Controllers\Auth\LoginController::class, 'otp'])->name('otp');
Route::get('files/download/{link}', [App\Http\Controllers\FileController::class, 'download'])->name('files.download');

Route::middleware(['web','auth','checkRole:user'])->group(function () {
Route::get('/', [App\Http\Controllers\UserController::class, 'index']);
Route::get('/home', [App\Http\Controllers\UserController::class, 'index'])->name('home');
});

Route::middleware(['web','auth','checkRole:admin'])->prefix('admin')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index']);
    Route::get('/index', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
});
Route::middleware(['web','auth','checkRole:admin'])->prefix('files')->group(function () {
    Route::get('/create', [App\Http\Controllers\FileController::class, 'create'])->name('files.create');
    Route::post('/store', [App\Http\Controllers\FileController::class, 'store'])->name('files.store');
});