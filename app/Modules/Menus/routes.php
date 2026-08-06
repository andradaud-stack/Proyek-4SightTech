<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Menus\Controllers\MenusController;

Route::controller(MenusController::class)->middleware(['web','auth'])->name('menus.')->group(function(){
	Route::get('/menus', 'index')->name('index');
	Route::get('/menus/data', 'data')->name('data.index');
	Route::get('/menus/create', 'create')->name('create');
	Route::post('/menus', 'store')->name('store');
	Route::get('/menus/{menus}', 'show')->name('show');
	Route::get('/menus/{menus}/edit', 'edit')->name('edit');
	Route::patch('/menus/{menus}', 'update')->name('update');
	Route::get('/menus/{menus}/delete', 'destroy')->name('destroy');
});
