<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'HomeController@index');
    Route::get('/access_denied', 'HomeController@accessDenied');

    /**
     * API device routes
     */
    Route::group(['prefix' => 'api-device'], function () {
        Route::get('/test/{device}', 'ApiDeviceController@testDevice');
    });

    /**
     * User routes
     */
    Route::group(['middleware' => ['user.sat'], 'prefix' => 'users'], function () {
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
        Route::get('/show/{id}', 'CustomerController@show');
        Route::get('/new', 'CustomerController@new');
        Route::post('/save', 'CustomerController@save');
        Route::put('/update/{id}', 'CustomerController@update');
        Route::get('/edit/{id}', 'CustomerController@edit');
        Route::get('/delete/{id}', 'CustomerController@destroy');

        /**
         * Contact routes
         */
        Route::group(['prefix' => 'contacts'], function () {
            Route::get('/', 'ContactController@index');
            Route::get('/show/{id}', 'ContactController@show');
            Route::post('/new', 'ContactController@save');
            Route::get('/delete/{id}', 'ContactController@destroy');
        });
    });

    /**
     * Contract routes
     */
    Route::group(['prefix' => 'contracts'], function () {
        Route::get('/', 'ContractController@index');
        Route::get('/new', 'ContractController@new');
        Route::get('/show/{id}', 'ContractController@show');
        //Route::get('/search/{cpj_cnpj}', 'ContractController@search');
        Route::post('/search', 'ContractController@search');

        Route::post('/add-device', 'ContractController@addDevice');
        Route::post('/remove-device', 'ContractController@removeDevice');
        //Route::get('/devices', 'ContractController@indexDevice');

        Route::post('/save', 'ContractController@save');
        Route::put('/update/{id}', 'ContractController@update');
        Route::get('/edit/{id}', 'ContractController@edit');
        Route::get('/delete/{id}', 'ContractController@destroy');
    });

    /**
     * Stocks routes
     */
    Route::group(['prefix' => 'stocks'], function () {
        Route::get('/', 'StockController@index');
    
    });


    /**
     * Devices routes
     */
    Route::group(['prefix' => 'devices'], function () {

        Route::get('/', 'DeviceController@index');
        Route::get('/new', 'DeviceController@new');
        Route::post('/save', 'DeviceController@save');
        Route::put('/update/{id}', 'DeviceController@update');
        Route::get('/edit/{id}', 'DeviceController@edit');
        Route::get('/delete/{id}', 'DeviceController@destroy');



        /**
         * Technologies routes
         */
        Route::group(['prefix' => 'technologies'], function () {
            Route::get('/', 'TechnologieController@index');
            Route::get('/new', 'TechnologieController@new');
            Route::post('/save', 'TechnologieController@save');
            Route::put('/update/{id}', 'TechnologieController@update');
            Route::get('/edit/{id}', 'TechnologieController@edit');
            Route::get('/delete/{id}', 'TechnologieController@destroy');
        });
    });

    Route::group(['prefix' => 'boardings'], function () {
        Route::get('/', 'BoardingController@index');
        Route::get('/new', 'BoardingController@new');
        Route::post('/save', 'BoardingController@save');
        Route::get('/delete/{id}', 'BoardingController@destroy');
        //Route::put('/update/{id}', 'BoardingController@update');

        Route::get('/test-device/{model}', 'BoardingController@testDevice');

        //Route::put('/update/{id}', 'BoardingController@update');
        //Route::get('/edit/{id}', 'BoardingController@edit');
        //Route::get('/delete/{id}', 'BoardingController@destroy');
    });

    /**
     * Logs routes
     */
    Route::group(['prefix' => 'logs'], function () {
        Route::get('/', 'LogController@index');
        Route::get('/new', 'LogController@new');
        Route::post('/save', 'LogController@save');
        Route::put('/update/{id}', 'LogController@update');
        Route::get('/edit/{id}', 'LogController@edit');
        Route::get('/delete/{id}', 'LogController@destroy');
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
     * Profile routes
     */
    Route::group(['prefix' => 'profiles'], function () {
        Route::get('/edit', 'ProfileController@editprofile');
        Route::post('/save', 'ProfileController@save');
        Route::put('/update', 'ProfileController@update');
    });

    /**
     * Exit router
     */
    Route::get('/logout', function () {
        \illuminate\Support\Facades\Auth::logout();
        return redirect('/');
    })->name('logout');
});
