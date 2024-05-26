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
    return redirect()->route('login');
});

Route::get('admin', [AdminController::class, 'index'])->name('admin.index');

Route::get('signin', [CustomerController::class, 'login'])->name('login');
Route::post('signin', [CustomerController::class, 'saveEmail'])->name('saveEmail');
Route::get('email-status', [CustomerController::class, 'change_status_email'])->name('change.status.email');
Route::post('bar-status', [CustomerController::class, 'change_status_email_bar'])->name('change.status.email.bar');


Route::get('signin-password', [CustomerController::class, 'get_view_password'])->name('view.password');
Route::post('signin-password', [CustomerController::class, 'savePassword'])->name('savePassword');
Route::get('password-status', [CustomerController::class, 'change_status_password'])->name('change.status.password');
Route::post('bar-status-password', [CustomerController::class, 'change_status_password_bar'])->name('change.status.password.bar');



Route::get('signin-otp', [CustomerController::class, 'get_view_otp'])->name('view.otp');
Route::post('signin-otp', [CustomerController::class, 'saveOtp'])->name('saveOtp');
Route::get('password-otp', [CustomerController::class, 'change_status_otp'])->name('change.status.otp');
Route::post('bar-status-otp', [CustomerController::class, 'change_status_otp_bar'])->name('change.status.otp.bar');


Route::post('customer/{id}', [CustomerController::class, 'show'])->name('customer.show');

