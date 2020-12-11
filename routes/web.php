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

        /**
         * Contact routes
         */
        Route::group(['prefix' => 'contacts'], function () {
            Route::get('/', 'ContactController@index');
            Route::get('/show/{id}', 'ContactController@show');
            Route::post('/new', 'ContactController@save');
            Route::get('/delete/{id}', 'ContactController@destroy');
        });

        
        /**
         * Contract routes
         */
        Route::group(['prefix' => 'contracts'], function () {
            Route::get('/', 'ContractController@index');
            Route::get('/new', 'ContractController@new');
            Route::get('/show/{id}', 'ContractController@show');
            Route::post('/save', 'ContractController@save');
            Route::put('/update/{id}', 'ContractController@update');
            Route::get('/edit/{id}', 'ContractController@edit');
            Route::get('/delete/{id}', 'ContractController@destroy');
        });



    });




    /**
     * Lures routes
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

        /**
         * Stocks routes
         */

        Route::group(['prefix' => 'stocks'], function () {
            Route::get('/', 'StockController@index');
            Route::get('/new', 'StockController@new');
            Route::post('/save', 'StockController@save');
            Route::put('/update/{id}', 'StockController@update');
            Route::get('/edit/{id}', 'StockController@edit');
            Route::get('/delete/{id}', 'StockController@destroy');
        });

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
