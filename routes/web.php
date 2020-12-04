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
    });


    /**
     * Clients routes
     */
    Route::group(['prefix' => 'customers'], function () {

        Route::get('/', 'CustomerController@index');
        Route::get('/new', 'CustomerController@new');
        Route::post('/save', 'CustomerController@save');
        Route::put('/update/{id}', 'CustomerController@update');
        Route::get('/edit/{id}', 'CustomerController@edit');
        Route::get('/delete/{id}', 'CustomerController@destroy');
    });


    /**
     * Lures routes
     */
    Route::group(['prefix' => 'lures'], function () {

        Route::get('/', 'LureController@index');
        Route::get('/new', 'LureController@new');
        Route::post('/save', 'LureController@save');
        Route::put('/update/{id}', 'LureController@update');
        Route::get('/edit/{id}', 'LureController@edit');
        Route::get('/delete/{id}', 'LureController@destroy');
    });


    /**
     * Type of Loads routes
     */
    Route::group(['prefix' => 'typeofloads'], function () {

        Route::get('/', 'TypeOfLoadController@index');
        Route::get('/new', 'TypeOfLoadController@new');
        Route::post('/save', 'TypeOfLoadController@save');
        Route::put('/update/{id}', 'TypeOfLoadController@update');
        Route::get('/edit/{id}', 'TypeOfLoadController@edit');
        Route::get('/delete/{id}', 'TypeOfLoadController@destroy');
    });


    /**
     * Accommodation Locations routes
     */
    Route::group(['prefix' => 'accommodationlocations'], function () {

        Route::get('/', 'AccommodationLocationsController@index');
        Route::get('/new', 'AccommodationLocationsController@new');
        Route::post('/save', 'AccommodationLocationsController@save');
        Route::put('/update/{id}', 'AccommodationLocationsController@update');
        Route::get('/edit/{id}', 'AccommodationLocationsController@edit');
        Route::get('/delete/{id}', 'AccommodationLocationsController@destroy');
    });



    /**
     * Exit router
     */
    Route::get('/logout', function () {
        \illuminate\Support\Facades\Auth::logout();
        return redirect('/');
    })->name('logout');
});
