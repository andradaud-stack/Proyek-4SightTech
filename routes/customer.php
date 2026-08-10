<?php

use App\Http\Controllers\Customer\CustomerAuthController;
use App\Http\Controllers\Customer\CustomerController;
use Illuminate\Support\Facades\Route;

Route::middleware('customer.guest')->group(function () {
    Route::get('/', [CustomerController::class,'index'])->name('frontend.index');
    Route::get('customer/login', [CustomerAuthController::class, 'showLogin'])->name('customer.login');
    Route::post('customer/login', [CustomerAuthController::class, 'login'])->name('customer.login.store');
    Route::get('customer/register', [CustomerAuthController::class, 'showRegister'])->name('customer.register');
    Route::post('customer/register', [CustomerAuthController::class, 'register'])->name('customer.register.store');
});

Route::middleware('customer.auth')->group(function () {
    Route::post('customer/logout', [CustomerAuthController::class, 'logout'])->name('customer.logout');
    Route::get('customer/home', function () {
        return view('customer.home');
    })->name('customer.home');
});
