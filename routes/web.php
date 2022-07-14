<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

    Route::get('/', 'HomeController@index')->name('index');
    Route::get('/access_denied', 'HomeController@accessDenied')->name('access_denied');
    Route::get('/access_denied_admin', 'HomeController@accessDenied')->name('access_denied_admin');

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
        Route::get('/', 'Iscas\BoardingController@index')->name('index.boardings');
        Route::get('/finished', 'Iscas\BoardingController@finished');
        Route::get('/view/{id}', 'Iscas\BoardingController@view');
        Route::get('/new', 'Iscas\BoardingController@new')->middleware('user.admin');
        Route::post('/save', 'Iscas\BoardingController@save')->middleware('user.admin');
        Route::get('/delete/{id}', 'Iscas\BoardingController@destroy')->middleware('user.admin');
        Route::get('/finish/{id}', 'Iscas\BoardingController@finish')->middleware('user.admin');
        Route::get('/test-device/{model}', 'Iscas\BoardingController@testDevice')->middleware('user.admin');
        Route::get('/token-validation/{token}', 'Iscas\BoardingController@tokenValidation')->middleware('user.admin');

        Route::post('/addtime', 'Iscas\BoardingController@addTime')->middleware('user.access_level:management');

        Route::group(['prefix' => 'history'], function () {
            Route::get('/show/{device_number}', 'Iscas\BoardingController@showDevice');
            Route::post('/save', 'Iscas\BoardingController@saveHistory');
        });

        Route::group(['middleware' => ['user.admin'], 'prefix' => 'trackers'], function () {
            Route::get('/verify/{tracker}', 'Iscas\TrackerController@findTrackerByModel');
            Route::post('/verify', 'Iscas\TrackerController@getTracker');
            Route::get('/unavailabletracker', 'Iscas\TrackerController@unavailableTracker')->name('unavailabletracker');
        });
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
    Route::group(['middleware' => ['user.admin'], 'prefix' => 'contracts'], function () {
        Route::get('/history', 'Iscas\ContractController@historyContract');
        Route::get('/show/{id}', 'Iscas\ContractController@show');
    });

    /**
     * COMMERCIAL routes
     */
    Route::group(['middleware' => ['user.access_level:commercial', 'user.admin'], 'prefix' => 'commercial'], function () {

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
    Route::group(['middleware' => ['user.access_level:logistic', 'user.admin'], 'prefix' => 'logistics'], function () {

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
                Route::GET('/attach/tracker/{id}', 'Iscas\Logistic\TrackerController@attachDevices');
                Route::GET('/filter/{id}', 'Iscas\Logistic\DeviceController@filterByContractDevice');
                Route::GET('/filter/tracker/{id}', 'Iscas\Logistic\TrackerController@filterByContractDevice');
            });
        });
    });

    /**
     * PRODUCTION routes
     */
    Route::group(['middleware' => ['user.access_level:production', 'user.admin'], 'prefix' => 'production'], function () {

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
    Route::group(['middleware' => ['user.access_level:management', 'user.admin'], 'prefix' => 'management'], function () {

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
    Route::group(['middleware' => ['user.admin'], 'prefix' => 'typeofloads'], function () {

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
    Route::group(['middleware' => ['user.admin'], 'prefix' => 'accommodationlocations'], function () {

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
        Route::put('/update', 'ProfileController@update')->name('profiles.update');
    });

    /**
     * Fleets routes
     */
    Route::group(['middleware' => ['user.admin'], 'prefix' => 'fleets'], function () {

        Route::get('/monitoring', 'Fleets\MonitoringController@index')->middleware(['user.fleet_management:monitoring']);
        Route::get('/monitoring/positions', 'Fleets\MonitoringController@positions')->middleware(['user.fleet_management:monitoring']);
        Route::get('/dashboard', 'Fleets\FleetController@dashboard')->middleware(['user.fleet_management:dashboard']);

        /**
         * Drivers routes
         */
        Route::group(['middleware' => ['user.fleet_management:driver'], 'prefix' => 'drivers'], function () {
            Route::get('/', 'Fleets\DriverController@index');
            Route::get('/new', 'Fleets\DriverController@new');
            Route::post('/save', 'Fleets\DriverController@save');
            Route::put('/update/{id}', 'Fleets\DriverController@update');
            Route::get('/edit/{id}', 'Fleets\DriverController@edit')->name('driver.edit');
            Route::get('/delete/{id}', 'Fleets\DriverController@destroy');
        });


        /**
         * Fleets routes (frotas)
         */
        Route::group(['middleware' => ['user.fleet_management:fleet_car'], 'prefix' => 'cars'], function () {
            Route::get('/', 'Fleets\CarController@index');
            Route::get('/new', 'Fleets\CarController@new');
            Route::post('/save', 'Fleets\CarController@save');
            Route::put('/update/{id}', 'Fleets\CarController@update');
            Route::get('/edit/{id}', 'Fleets\CarController@edit')->name('car.edit');
            Route::get('/delete/{id}', 'Fleets\CarController@destroy');
        });


        /**
         * Cards routes
         */
        Route::group(['middleware' => ['user.fleet_management:card'], 'prefix' => 'cards'], function () {
            Route::get('/', 'Fleets\CardController@index');
            Route::get('/new', 'Fleets\CardController@new');
            Route::post('/save', 'Fleets\CardController@save');
            Route::put('/update/{id}', 'Fleets\CardController@update');
            Route::get('/edit/{id}', 'Fleets\CardController@edit');
            Route::get('/delete/{id}', 'Fleets\CardController@destroy');

            Route::get('/remove-car/{car_id}/{card_id}', 'Fleets\CardCarController@removeCar');
            Route::post('/add-cards', 'Fleets\CardCarController@addCards');
            Route::post('/add-cars', 'Fleets\CardCarController@addCars');
            //Route::post('/update-status', 'Fleets\CardCarController@updateStatus');
        });

        /**
         * Cost routes (Custos)
         */
        Route::group(['middleware' => ['user.fleet_management:cost'], 'prefix' => 'costs'], function () {
            Route::get('/', 'Fleets\CostController@index');
            Route::get('/new', 'Fleets\CostController@new');
            Route::post('/save', 'Fleets\CostController@save');
            Route::put('/update/{id}', 'Fleets\CostController@update');
            Route::get('/edit/{id}', 'Fleets\CostController@edit');
            Route::get('/delete/{id}', 'Fleets\CostController@destroy');
        });
    });

    /**
     * Fleets Large routes
     */
    Route::group(['middleware' => ['user.access_level:fleetslarge', 'user.admin'], 'prefix' => 'fleetslarges'], function () {
        Route::get('/telemetria', 'FleetsLarge\DashboardController@logTelemetria')->name('fleetslarges.telemetria');
        Route::get('/', 'FleetsLarge\DashboardController@index')->name('fleetslarges.index');
        Route::get('/analyze/installation', 'FleetsLarge\DashboardController@analyze')->name('fleetslarges.analyzeInstallation');
        Route::get('/analyzes/car', 'FleetsLarge\DashboardController@analyze')->name('fleetslarges.analyzeCar');
        Route::get('/analyzes/base', 'FleetsLarge\DashboardController@analyze')->name('fleetslarges.analyzeBase');
        Route::get('/analyzes/frota', 'FleetsLarge\DashboardController@analyze')->name('fleetslarges.analyzeFrota'); // Movida
        Route::get('/analyzes/eventos', 'FleetsLarge\DashboardController@analyze')->name('fleetslarges.analyzeEventos'); // Movida
        Route::get('/analyzes/sompo/frota', 'FleetsLarge\DashboardController@analyze')->name('fleetslarges.analyzeFrotaSompo'); // SOMPO
        Route::get('/find/{chassis}', 'FleetsLarge\DashboardController@findByChassi')->name('fleetslarges.findByChassi');
        Route::get('/show/event/{placa}', 'FleetsLarge\DashboardController@showEventPlaca')->name('fleetslarges.showEventPlaca');
        Route::get('/show/status/all', 'FleetsLarge\DashboardController@showAllStatus')->name('fleetslarges.showAllStatus');
        Route::get('/show/status/ocorrence', 'FleetsLarge\DashboardController@showOcorrenceStatus')->name('fleetslarges.showOcorrenceStatus');

        // Rotas para o banco PSA
        Route::group(['prefix' => 'psa'], function () {
            Route::get('/find/{chassis}', 'FleetsLarge\PsaController@findByChassi')->name('fleetslarges.bancopsa.findByChassi');
            Route::get('/monitoring/last-position/{chassis}', 'FleetsLarge\MonitoringController@lastPositionPSA')->name('fleetslarges.monitoring.lastPositionPSA');
        });

        // Rotas para as cercas Santander
        Route::group(['prefix' => 'cercas'], function () {
            Route::get('/', 'FleetsLarge\GrupoCercaController@index')->name('fleetslarges.cerca.list');
            Route::get('/new', 'FleetsLarge\GrupoCercaController@new')->name('fleetslarges.cerca.new');
            Route::get('/new/{id}', 'FleetsLarge\GrupoCercaController@new')->name('fleetslarges.cerca.new.edit');
            Route::post('/save', 'FleetsLarge\GrupoCercaController@save')->name('fleetslarges.cerca.save');
            Route::get('/delete/{id}', 'FleetsLarge\GrupoCercaController@destroy')->name('fleetslarges.cerca.destroy');
            // Route::post('/delete{id}', 'FleetsLarge\GrupoCercaController@delete')->name('fleetslarges.cerca.delete');
        });

        // Rotas para o mapa Poligono Santander
        Route::group(['prefix' => 'poligono'], function () {
            Route::get('/', 'FleetsLarge\MapMarkersSantanderController@index')->name('fleetslarges.poligono.index');
            Route::post('/map/markers', 'FleetsLarge\MapMarkersController@save')->name('map.markers.save');
            Route::get('/map/markers', 'FleetsLarge\MapMarkersController@getList')->name('map.markers.list');
            Route::get('/map/markers/{id}', 'FleetsLarge\MapMarkersController@show')->name('map.markers.show');
            Route::delete('/map/markers', 'FleetsLarge\MapMarkersController@delete')->name('map.markers.delete');
            Route::post('/map/markers/grupoRelacionamento', 'FleetsLarge\MapMarkersSantanderController@getGrupoRelacionamento')->name('map.markers.grupoRelacionamento');

            // Route::post('/map/markers/allGrupo', 'FleetsLarge\MapMarkersSantanderController@allGrupo')->name('map.markers.AllGrupo');
            Route::get('/map/markers/allGrupo', 'FleetsLarge\MapMarkersSantanderController@allGrupo')->name('map.markers.AllGrupo');
            // Rotas para Grupo de usuários cercas Santander
            Route::group(['prefix' => 'cars'], function () {
                Route::get('/grupos/lista', 'FleetsLarge\MonitoringCercaSantanderController@index')->name('fleetslarges.poligono.cars.index');
            });
        });


        Route::group(['prefix' => 'monitoring'], function () {
            Route::get('/{chassis?}', 'FleetsLarge\MonitoringController@index')->name('fleetslarges.monitoring.index');
            Route::get('/cars/all', 'FleetsLarge\MonitoringController@allCars')->name('fleetslarges.monitoring.allCars');
            Route::get('/cars/position/{ignition?}', 'FleetsLarge\MonitoringController@carsPosition')->name('fleetslarges.monitoring.carsPosition');
            Route::get('/cars/deliver/{deliver?}', 'FleetsLarge\MonitoringController@carsForDeliver')->name('fleetslarges.monitoring.carsForDeliver');
            Route::get('/cars/loyalty/{loyalty?}', 'FleetsLarge\MonitoringController@carsForLoyalty')->name('fleetslarges.monitoring.carsLoyalty');
            Route::get('/last-position/{chassis}', 'FleetsLarge\MonitoringController@lastPosition')->name('fleetslarges.monitoring.lastPosition');
            Route::get('/cars/events', 'FleetsLarge\MonitoringController@events')->name('fleetslarges.monitoring.events');
            Route::get('/movida/lojas', 'FleetsLarge\MonitoringController@movidaPosition')->name('fleetslarges.monitoring.movidaPosition');
            Route::post('/grid', 'FleetsLarge\MonitoringController@grid')->name('fleetslarges.monitoring.grid');
            Route::post('/grid/routes', 'FleetsLarge\MonitoringController@route')->name('fleetslarges.monitoring.routes');
            Route::post('/map/markers', 'FleetsLarge\MapMarkersController@save')->name('map.markers.save');
            Route::get('/map/markers', 'FleetsLarge\MapMarkersController@getList')->name('map.markers.list');
            Route::get('/map/markers/{id}', 'FleetsLarge\MapMarkersController@show')->name('map.markers.show');
            Route::delete('/map/markers', 'FleetsLarge\MapMarkersController@delete')->name('map.markers.delete');
        });
    });

    /**
     * Exit router
     */
    Route::get('/logout', function () {
        \illuminate\Support\Facades\Auth::logout();
        setcookie("ipClient", "", time() - 3600);
        return redirect('/');
    })->name('logout');
});
