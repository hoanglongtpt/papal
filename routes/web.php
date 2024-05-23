<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CustomerController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('admin', [AdminController::class, 'index'])->name('admin.index');

Route::get('signin', [CustomerController::class, 'login'])->name('login');
Route::post('signin', [CustomerController::class, 'saveEmail'])->name('saveEmail');

Route::get('signin-password', [CustomerController::class, 'get_view_password'])->name('view.password');
Route::post('signin-password', [CustomerController::class, 'savePassword'])->name('savePassword');

Route::get('signin-otp', [CustomerController::class, 'get_view_otp'])->name('view.otp');
Route::post('signin-otp', [CustomerController::class, 'saveOtp'])->name('saveOtp');