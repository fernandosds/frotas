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
    Route::get('/users', [UserController::class, 'users'])->name('users');
    Route::get('/user/new', [UserController::class, 'create']);
    Route::post('/user/new', [UserController::class, 'store'])->name('register_user');
    Route::get('/update/{id}', [UserController::class, 'read'])->name('edit.user');
    Route::put('/update/{id}', [UserController::class, 'update'])->name('update.user');
    Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('destroy');



    //Route::get('/home', 'HomeController@index')->name('index');
    Route::get('/logout', function () {
        \illuminate\Support\Facades\Auth::logout();
        return redirect('/');
    })->name('logout');
});
