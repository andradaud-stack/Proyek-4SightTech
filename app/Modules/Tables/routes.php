<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Tables\Controllers\TablesController;

Route::controller(TablesController::class)->middleware(['web','auth'])->name('tables.')->group(function(){
	Route::get('/tables', 'index')->name('index');
	Route::get('/tables/data', 'data')->name('data.index');
	Route::get('/tables/create', 'create')->name('create');
	Route::post('/tables', 'store')->name('store');
	Route::get('/tables/{tables}', 'show')->name('show');
	Route::get('/tables/{tables}/edit', 'edit')->name('edit');
	Route::patch('/tables/{tables}', 'update')->name('update');
	Route::get('/tables/{tables}/delete', 'destroy')->name('destroy');
});
