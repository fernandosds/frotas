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
     * Contract routes
     */
    Route::group(['prefix' => 'commercial'], function () {

        /**
         * Clients routes
         */
        Route::group(['prefix' => 'customers'], function () {

            Route::get('/', 'Commercial\CustomerController@index');
            Route::get('/show/{id}', 'Commercial\CustomerController@show');
            Route::get('/new', 'Commercial\CustomerController@new');
            Route::post('/save', 'Commercial\CustomerController@save');
            Route::put('/update/{id}', 'Commercial\CustomerController@update');
            Route::get('/edit/{id}', 'Commercial\CustomerController@edit');
            Route::get('/delete/{id}', 'Commercial\CustomerController@destroy');

            /**
             * Contact routes
             */
            Route::group(['prefix' => 'contacts'], function () {
                Route::get('/', 'Commercial\ContactController@index');
                Route::get('/show/{id}', 'Commercial\ContactController@show');
                Route::post('/new', 'Commercial\ContactController@save');
                Route::get('/delete/{id}', 'Commercial\ContactController@destroy');
            });
        });

        Route::group(['prefix' => 'contracts'], function () {
            Route::get('/', 'Commercial\ContractController@index');
            Route::get('/new', 'Commercial\ContractController@new');
            Route::get('/show/{id}', 'Commercial\ContractController@show');
            Route::post('/save', 'Commercial\ContractController@save');
            Route::put('/update/{id}', 'Commercial\ContractController@update');
            Route::get('/edit/{id}', 'Commercial\ContractController@edit');
            Route::get('/delete/{id}', 'Commercial\ContractController@destroy');

            Route::group(['prefix' => 'devices'], function () {
                Route::post('/add', 'Commercial\DeviceController@add');
                Route::post('/remove', 'Commercial\DeviceController@remove');
            });
        });

        Route::group(['prefix' => 'customer'], function () {
            Route::post('/search', 'Commercial\CustomerController@search');
        });



    });

    /**
     * Stocks routes
     */
    Route::group(['prefix' => 'stocks'], function () {
        Route::get('/', 'StockController@index');
    });

    /**
     * Logistics  routes
     */
    Route::group(['prefix' => 'logistics'], function () {

        /**
         * Contracts Logistics  routes
         */
        Route::group(['prefix' => 'contracts'], function () {
            Route::get('/edit/{id}', 'Logistic\ContractController@edit');
            Route::put('/update/{id}', 'Logistic\ContractController@update');
            Route::get('/', 'Logistic\LogisticController@index');

            Route::get('/completed', 'Logistic\ContractController@contractCompleted');
            Route::get('/show/{id}', 'Logistic\ContractController@show');
           

            /**
             * Devices
             */
            Route::group(['prefix' => 'devices'], function () {
                Route::GET('/attach/{id}', 'Logistic\DeviceController@attachDevices');
                Route::GET('/filter/{id}', 'Logistic\DeviceController@filterByContractDevice');
            });
        });
    });

    /**
     * Production routes
     */
    Route::group(['prefix' => 'production'], function () {

        /**
         * Devices routes
         */
        Route::group(['prefix' => 'devices'], function () {

            Route::get('/', 'Production\DeviceController@index');
            Route::get('/new', 'Production\DeviceController@new');
            Route::post('/save', 'Production\DeviceController@save');
            Route::put('/update/{id}', 'Production\DeviceController@update');
            Route::get('/edit/{id}', 'Production\DeviceController@edit');
            Route::get('/delete/{id}', 'Production\DeviceController@destroy');

            /**
             * Technologies routes
             */
            Route::group(['prefix' => 'technologies'], function () {
                Route::get('/', 'Production\TechnologieController@index');
                Route::get('/new', 'Production\TechnologieController@new');
                Route::post('/save', 'Production\TechnologieController@save');
                Route::put('/update/{id}', 'Production\TechnologieController@update');
                Route::get('/edit/{id}', 'Production\TechnologieController@edit');
                Route::get('/delete/{id}', 'Production\TechnologieController@destroy');
            });
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
