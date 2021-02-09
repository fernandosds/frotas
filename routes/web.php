<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Auth::routes();


/**
 * API device routes
 */

Route::group(['prefix' => 'users'], function () {
    Route::post('/password/reset', 'UserController@resetPassword');
});



Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'HomeController@index');
    Route::get('/access_denied', 'HomeController@accessDenied');

    /**
     * API device routes
     */
    Route::group(['prefix' => 'api-device'], function () {
        Route::get('/test/{device}', 'ApiDeviceController@testDevice');
        Route::get('/get-device/{placa}', 'ApiDeviceController@getDevice');
    });

    /**
     * boardings device routes
     */
    Route::group(['prefix' => 'boardings'], function () {
        Route::get('/', 'BoardingController@index');
        Route::get('/view/{id}', 'BoardingController@view');
        Route::get('/new', 'BoardingController@new');
        Route::post('/save', 'BoardingController@save');
        Route::get('/delete/{id}', 'BoardingController@destroy');
        Route::get('/finish/{id}', 'BoardingController@finish');

        Route::get('/test-device/{model}', 'BoardingController@testDevice');
    });

    /**
     * boardings device routes
     */
    Route::group(['prefix' => 'monitoring'], function () {
        Route::get('/{device?}', 'MonitoringController@index');
        Route::get('/map/{device}', 'MonitoringController@map');

        Route::get('/test-device/{model}', 'MonitoringController@testDevice');
    });

    /**
     * Contracts History routes
     */
    Route::group(['prefix' => 'contracts'], function () {
        Route::get('/history', 'ContractController@historyContract');
        Route::get('/show/{id}', 'ContractController@show');
    });

    /**
     * COMMERCIAL routes
     */
    Route::group(['middleware' => ['user.access_level:commercial'], 'prefix' => 'commercial'], function () {

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
     * Contracts History routes
     */
    Route::group(['prefix' => 'contracts'], function () {
        Route::get('/history', 'ContractController@historyContract');
    });


    /**
     * Stocks routes
     */
    Route::group(['prefix' => 'stocks'], function () {
        Route::get('/', 'StockController@index');
        Route::get('/history', 'StockController@historyContract');
    });

    /**
     * LOGISTIC  routes
     */
    Route::group(['middleware' => ['user.access_level:logistic'], 'prefix' => 'logistics'], function () {

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
     * PRODUCTION routes
     */
    Route::group(['middleware' => ['user.access_level:production'], 'prefix' => 'production'], function () {

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

    /**
     * MANAGEMENT routes
     */
    Route::group(['middleware' => ['user.access_level:management'], 'prefix' => 'management'], function () {

        /**
         * User routes
         */
        Route::group(['middleware' => ['user.sat'], 'prefix' => 'users'], function () {
            Route::get('/', 'Management\UserController@index');
            Route::get('/new', 'Management\UserController@new');
            Route::post('/save', 'Management\UserController@save');
            Route::put('/update/{id}', 'Management\UserController@update');
            Route::get('/edit/{id}', 'Management\UserController@edit');
            Route::get('/delete/{id}', 'Management\UserController@destroy');
        });

        Route::group(['prefix' => 'logs'], function () {
            Route::get('/', 'Management\LogController@index');
            Route::get('/new', 'Management\LogController@new');
            Route::post('/save', 'Management\LogController@save');
            Route::put('/update/{id}', 'Management\LogController@update');
            Route::get('/edit/{id}', 'Management\LogController@edit');
            Route::get('/delete/{id}', 'Management\LogController@destroy');
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
     * Profile routes
     */
    Route::group(['prefix' => 'profiles'], function () {
        Route::get('/edit', 'ProfileController@editprofile');
        Route::post('/save', 'ProfileController@save');
        Route::put('/update', 'ProfileController@update');
    });



    /**
     * Rent routes
     */


    Route::group(['prefix' => 'rents'], function () {

        /**
         * Drivers routes
         */

        Route::group(['prefix' => 'drivers'], function () {
        });

        
        /**
         * Fleets routes (frotas)
         */

        Route::group(['prefix' => 'cars'], function () {
            Route::get('/', 'Rent\CarController@index');
        });


        /**
         * Cards routes 
         */

        Route::group(['prefix' => 'cards'], function () {
        });


        /**
         * Cost routes (Custos)
         */

        Route::group(['prefix' => 'cost'], function () {
        });

        
    });

    /**
     * Exit router
     */
    Route::get('/logout', function () {
        \illuminate\Support\Facades\Auth::logout();
        return redirect('/');
    })->name('logout');
});
