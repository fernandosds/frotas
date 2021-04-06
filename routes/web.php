<?php

use Illuminate\Support\Facades\Route;

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

/**
 * API device routes
 */

Route::group(['prefix' => 'tasks'], function () {
    Route::get('/boardings/finalizes', 'TasksController@autoFinatlizeBoardings');
});

Route::group(['prefix' => 'users'], function () {
    Route::post('/password/reset', 'UserController@resetPassword');
});

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'HomeController@index');
    Route::get('/access_denied', 'HomeController@accessDenied')->name('access_denied');

    /**
     * API device routes
     */
    Route::group(['prefix' => 'api-device'], function () {
        Route::get('/test/{device}', 'ApiDeviceController@testDevice');
        Route::get('/get-device/{placa}', 'ApiDeviceController@getDevice');
        Route::get('/last-position/{model}', 'ApiDeviceController@getLastPosition');
    });

    /**
     * boardings device routes
     */
    Route::group(['prefix' => 'boardings'], function () {
        Route::get('/', 'Iscas\BoardingController@index');
        Route::get('/finished', 'Iscas\BoardingController@finished');
        Route::get('/view/{id}', 'Iscas\BoardingController@view');
        Route::get('/new', 'Iscas\BoardingController@new');
        Route::post('/save', 'Iscas\BoardingController@save');
        Route::get('/delete/{id}', 'Iscas\BoardingController@destroy');
        Route::get('/finish/{id}', 'Iscas\BoardingController@finish');
        Route::get('/test-device/{model}', 'Iscas\BoardingController@testDevice');
        Route::get('/token-validation/{token}', 'Iscas\BoardingController@tokenValidation');

        Route::post('/addtime', 'Iscas\BoardingController@addTime')->middleware('user.access_level:management');
    });

    /**
     * boardings device routes
     */
    Route::group(['middleware' => ['user.access_level:management'], 'prefix' => 'monitoring'], function () {
        Route::get('/{device?}', 'Iscas\MonitoringController@index');
        Route::get('/map/last-position/{device}', 'Iscas\MonitoringController@lastPosition');
        Route::get('/map/heat/{device}/{minutes?}', 'Iscas\MonitoringController@heat');
        Route::get('/get-grid/{model}/{minutes}', 'Iscas\MonitoringController@getGrid');
        Route::get('/get-grid/print/{model}/{from}/{to}', 'Iscas\MonitoringController@printGrid');
        Route::get('/get-address/{lat}/{lng}', 'Iscas\MonitoringController@getAddress');
        Route::get('/check-pairing/{device}/{pair_device}', 'Iscas\MonitoringController@checkPairing');
        Route::get('/test-device/{model}', 'Iscas\MonitoringController@testDevice');
    });

    /**
     * Contracts History routes
     */
    Route::group(['prefix' => 'contracts'], function () {
        Route::get('/history', 'Iscas\ContractController@historyContract');
        Route::get('/show/{id}', 'Iscas\ContractController@show');
    });

    /**
     * COMMERCIAL routes
     */
    Route::group(['middleware' => ['user.access_level:commercial'], 'prefix' => 'commercial'], function () {

        /**
         * Clients routes
         */
        Route::group(['prefix' => 'customers'], function () {

            Route::get('/', 'Iscas\Commercial\CustomerController@index');
            Route::get('/show/{id}', 'Iscas\Commercial\CustomerController@show');
            Route::get('/new', 'Iscas\Commercial\CustomerController@new');
            Route::post('/save', 'Iscas\Commercial\CustomerController@save');
            Route::put('/update/{id}', 'Iscas\Commercial\CustomerController@update');
            Route::get('/edit/{id}', 'Iscas\Commercial\CustomerController@edit');
            Route::get('/delete/{id}', 'Iscas\Commercial\CustomerController@destroy');

            /**
             * Contact routes
             */
            Route::group(['prefix' => 'contacts'], function () {
                Route::get('/', 'Iscas\Commercial\ContactController@index');
                Route::get('/show/{id}', 'Iscas\Commercial\ContactController@show');
                Route::post('/new', 'Iscas\Commercial\ContactController@save');
                Route::get('/delete/{id}', 'Iscas\Commercial\ContactController@destroy');
            });
        });

        Route::group(['prefix' => 'contracts'], function () {
            Route::get('/', 'Iscas\Commercial\ContractController@index');
            Route::get('/new/{id?}', 'Iscas\Commercial\ContractController@new');
            Route::get('/show/{id}', 'Iscas\Commercial\ContractController@show');
            Route::post('/save', 'Iscas\Commercial\ContractController@save');
            Route::put('/update/{id}', 'Iscas\Commercial\ContractController@update');
            Route::get('/edit/{id}', 'Iscas\Commercial\ContractController@edit');
            Route::get('/delete/{id}', 'Iscas\Commercial\ContractController@destroy');

            Route::group(['prefix' => 'devices'], function () {
                Route::post('/add', 'Iscas\Commercial\DeviceController@add');
                Route::post('/remove', 'Iscas\Commercial\DeviceController@remove');
            });
        });

        Route::group(['prefix' => 'customer'], function () {
            Route::post('/search', 'Iscas\Commercial\CustomerController@search');
        });
    });

    /**
     * Contracts History routes
     */
    Route::group(['prefix' => 'contracts'], function () {
        Route::get('/history', 'Iscas\ContractController@historyContract');
    });


    /**
     * Stocks routes
     */
    Route::group(['prefix' => 'stocks'], function () {
        Route::get('/', 'Iscas\StockController@index');
        Route::get('/history', 'Iscas\StockController@historyContract');
    });

    /**
     * LOGISTIC  routes
     */
    Route::group(['middleware' => ['user.access_level:logistic'], 'prefix' => 'logistics'], function () {

        /**
         * Contracts Logistics  routes
         */
        Route::group(['prefix' => 'contracts'], function () {
            Route::get('/edit/{id}', 'Iscas\Logistic\ContractController@edit');
            Route::put('/update/{id}', 'Iscas\Logistic\ContractController@update');
            Route::get('/', 'Iscas\Logistic\LogisticController@index');

            Route::get('/completed', 'Iscas\Logistic\ContractController@contractCompleted');
            Route::get('/show/{id}', 'Iscas\Logistic\ContractController@show');


            /**
             * Devices
             */
            Route::group(['prefix' => 'devices'], function () {
                Route::GET('/attach/{id}', 'Iscas\Logistic\DeviceController@attachDevices');
                Route::GET('/filter/{id}', 'Iscas\Logistic\DeviceController@filterByContractDevice');
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

            Route::get('/', 'Iscas\Production\DeviceController@index');
            Route::get('/new', 'Iscas\Production\DeviceController@new');
            Route::post('/save', 'Iscas\Production\DeviceController@save');
            Route::put('/update/{id}', 'Iscas\Production\DeviceController@update');
            Route::get('/edit/{id}', 'Iscas\Production\DeviceController@edit');
            Route::get('/delete/{id}', 'Iscas\Production\DeviceController@destroy');

            /**
             * Technologies routes
             */
            Route::group(['prefix' => 'technologies'], function () {
                Route::get('/', 'Iscas\Production\TechnologieController@index');
                Route::get('/new', 'Iscas\Production\TechnologieController@new');
                Route::post('/save', 'Iscas\Production\TechnologieController@save');
                Route::put('/update/{id}', 'Iscas\Production\TechnologieController@update');
                Route::get('/edit/{id}', 'Iscas\Production\TechnologieController@edit');
                Route::get('/delete/{id}', 'Iscas\Production\TechnologieController@destroy');
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
        Route::group(['prefix' => 'users'], function () {
            Route::get('/', 'Management\UserController@index');
            Route::get('/new', 'Management\UserController@new');
            Route::post('/save', 'Management\UserController@save');
            Route::put('/update/{id}', 'Management\UserController@update');
            Route::post('/permission/update/{id}', 'Management\UserController@updatePermission')->name('user.permission.update');
            Route::get('/edit/{id}', 'Management\UserController@edit')->name('user.edit');
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

        Route::get('/', 'Iscas\TypeOfLoadController@index');
        Route::get('/new', 'Iscas\TypeOfLoadController@new');
        Route::post('/save', 'Iscas\TypeOfLoadController@save');
        Route::put('/update/{id}', 'Iscas\TypeOfLoadController@update');
        Route::get('/edit/{id}', 'Iscas\TypeOfLoadController@edit');
        Route::get('/delete/{id}', 'Iscas\TypeOfLoadController@destroy');
    });

    /**
     * Accommodation Locations routes
     */
    Route::group(['prefix' => 'accommodationlocations'], function () {

        Route::get('/', 'Iscas\AccommodationLocationsController@index');
        Route::get('/new', 'Iscas\AccommodationLocationsController@new');
        Route::post('/save', 'Iscas\AccommodationLocationsController@save');
        Route::put('/update/{id}', 'Iscas\AccommodationLocationsController@update');
        Route::get('/edit/{id}', 'Iscas\AccommodationLocationsController@edit');
        Route::get('/delete/{id}', 'Iscas\AccommodationLocationsController@destroy');
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
     * Fleets routes
     */
    Route::group(['prefix' => 'fleets'], function () {

        Route::get('/monitoring', 'Fleets\MonitoringController@index');
        Route::get('/monitoring/positions', 'Fleets\MonitoringController@positions');

        Route::get('/dashboard', 'Fleets\FleetController@dashboard');

        /**
         * Drivers routes
         */
        Route::group(['prefix' => 'drivers'], function () {
            Route::get('/', 'Fleets\DriverController@index');
            Route::get('/new', 'Fleets\DriverController@new');
            Route::post('/save', 'Fleets\DriverController@save');
            Route::put('/update/{id}', 'Fleets\DriverController@update');
            Route::get('/edit/{id}', 'Fleets\DriverController@edit');
            Route::get('/delete/{id}', 'Fleets\DriverController@destroy');
        });


        /**
         * Fleets routes (frotas)
         */
        Route::group(['prefix' => 'cars'], function () {
            Route::get('/', 'Fleets\CarController@index');
            Route::get('/new', 'Fleets\CarController@new');
            Route::post('/save', 'Fleets\CarController@save');
            Route::put('/update/{id}', 'Fleets\CarController@update');
            Route::get('/edit/{id}', 'Fleets\CarController@edit');
            Route::get('/delete/{id}', 'Fleets\CarController@destroy');
        });


        /**
         * Cards routes
         */
        Route::group(['prefix' => 'cards'], function () {
            Route::get('/', 'Fleets\CardController@index');
            Route::get('/new', 'Fleets\CardController@new');
            Route::post('/save', 'Fleets\CardController@save');
            Route::put('/update/{id}', 'Fleets\CardController@update');
            Route::get('/edit/{id}', 'Fleets\CardController@edit');
            Route::get('/delete/{id}', 'Fleets\CardController@destroy');
        });


        /**
         * Cost routes (Custos)
         */
        Route::group(['prefix' => 'costs'], function () {
            Route::get('/', 'Fleets\CostController@index');
            Route::get('/new', 'Fleets\CostController@new');
            Route::post('/save', 'Fleets\CostController@save');
            Route::put('/update/{id}', 'Fleets\CostController@update');
            Route::get('/edit/{id}', 'Fleets\CostController@edit');
            Route::get('/delete/{id}', 'Fleets\CostController@destroy');
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
