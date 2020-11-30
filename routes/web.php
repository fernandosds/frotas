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
        Route::get('/edit/{id}', 'UserController@edit');
        Route::get('/delete/{id}', 'UserController@destroy');
    });

    /**
     * Clients routes
     */
    Route::group(['prefix' => 'customers'], function () {

        Route::get('/', 'CustomerController@index');
        Route::get('/new', 'CustomerController@new');
        Route::post('/save', 'CustomerController@save');
        Route::get('/edit/{id}', 'CustomerController@edit');
        Route::get('/delete/{id}', 'CustomerController@destroy');
    });


    Route::get('/logout', function () {
        \illuminate\Support\Facades\Auth::logout();
        return redirect('/');
    })->name('logout');
});
