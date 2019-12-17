<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::auth();

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', 'TaskController@view');
    Route::group(['prefix' => 'tasks'], function() {
        Route::put('{id}', 'TaskController@edit')->where('id', '[0-9]+');
        Route::delete('{id}', 'TaskController@delete')->where('id', '[0-9]+');
        Route::post('/', 'TaskController@add');
    });
});
