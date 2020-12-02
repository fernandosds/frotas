<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'HomeController@index');

    /**
     * User routes
     */
    Route::group(['prefix' => 'users'], function () {

        Route::get('/', 'UserController@index');
        Route::get('/new', 'UserController@new');
        Route::post('/save', 'UserController@save');
        Route::put('/update/{id}', 'UserController@update');
        Route::get('/edit/{id}', 'UserController@edit');
        Route::get('/delete/{id}', 'UserController@destroy');

/*
        Route::get('/create', 'UserController@create');
        Route::post('/new', 'UserController@store');
        Route::get('/edit/{id}', 'UserController@edit');
        Route::post('/edit', 'UserController@update');
        Route::get('/delete/{id}', 'UserController@destroy');
*/
    });

    Route::get('/logout', function () {
        \illuminate\Support\Facades\Auth::logout();
        return redirect('/');
    })->name('logout');

});
