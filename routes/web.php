<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ThreadsController;
use App\Http\Controllers\MessagesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => '/api'], function () {

    Route::group(['prefix' => '/auth'], function () {
        Route::post('/register',       [RegistrationController::class, 'create']);
        Route::post('/login',          [LoginController::class, 'login']);
        Route::post('/sessionStatus',  [LoginController::class, 'sessionStatus']);
    });

    Route::group(['prefix' => '/threads'], function () {
        Route::post('/create',       [ThreadsController::class, 'create']);
        Route::post('/view',       [ThreadsController::class, 'get_threads']);
        Route::post('/get',       [ThreadsController::class, 'get_thread']);
    });

    Route::group(['prefix' => '/messages'], function () {
        Route::post('/create',       [MessagesController::class, 'create']);
    });

});

Route::get('/logout',  [LoginController::class, 'logout']);

Route::get('{any}', function () {
    return view('welcome');
})->where('any','.*');
