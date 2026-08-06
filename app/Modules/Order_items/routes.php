<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Order_items\Controllers\Order_itemsController;

Route::controller(Order_itemsController::class)->middleware(['web','auth'])->name('order_items.')->group(function(){
	Route::get('/order_items', 'index')->name('index');
	Route::get('/order_items/data', 'data')->name('data.index');
	Route::get('/order_items/create', 'create')->name('create');
	Route::post('/order_items', 'store')->name('store');
	Route::get('/order_items/{order_items}', 'show')->name('show');
	Route::get('/order_items/{order_items}/edit', 'edit')->name('edit');
	Route::patch('/order_items/{order_items}', 'update')->name('update');
	Route::get('/order_items/{order_items}/delete', 'destroy')->name('destroy');
});
