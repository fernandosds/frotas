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

    Route::get('/', [UserController::class, 'index'])->name('index');


    //Route User
    Route::group(['prefix' => 'users'], function () {

        Route::get('/', [UserController::class, 'users'])->name('users');
        Route::get('/create', [UserController::class, 'create'])->name('form_cad_user');
        Route::post('/new', [UserController::class, 'store'])->name('register_user');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit.user');
        Route::post('/edit', [UserController::class, 'update'])->name('update.user');
        Route::get('/delete/{id}', [UserController::class, 'destroy'])->name('destroy');
    });



    Route::get('/logout', function () {
        \illuminate\Support\Facades\Auth::logout();
        return redirect('/');
    })->name('logout');
});
