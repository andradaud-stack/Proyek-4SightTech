<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Orders\Controllers\OrdersController;

Route::controller(OrdersController::class)->middleware(['web','auth'])->name('orders.')->group(function(){
	Route::get('/orders', 'index')->name('index');
	Route::get('/orders/data', 'data')->name('data.index');
	Route::get('/orders/create', 'create')->name('create');
	Route::post('/orders', 'store')->name('store');
	Route::get('/orders/{orders}', 'show')->name('show');
	Route::get('/orders/{orders}/edit', 'edit')->name('edit');
	Route::patch('/orders/{orders}', 'update')->name('update');
	Route::get('/orders/{orders}/delete', 'destroy')->name('destroy');
});
