<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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



Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    //Route User
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/user/new', [UserController::class, 'create']);
    Route::post('/user/new', [UserController::class, 'store'])->name('register');
    
    /**
    Route::post('/user/new', function () {
        return view('newuser')->name('register');
    }); 
     */
    

    //Route::get('/home', 'HomeController@index')->name('index');
    Route::get('/logout', function () {
        \illuminate\Support\Facades\Auth::logout();
        return redirect('/');
    })->name('logout');
});
