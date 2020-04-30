<?php

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

Route::get('/','HomeController@index');
Route::post('/form/contact', 'ContactController@create')
    ->name('sendSubmission');


Route::group(['middleware' => 'auth'], function(){

    Route::get('/dashboard', 'DashboardController@index');

    Route::group(['prefix' => '/applications'], function (){

        Route::get('/pending', 'ApplicationController@showPendingUserApps');
        Route::get('/denied', 'ApplicationController@showDeniedUserApps');

    });

});

//Route::get('/dashboard/login', '');

