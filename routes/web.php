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

    Route::group(['prefix' => '/applications'], function (){

        Route::get('/pending', 'ApplicationController@showPendingUserApps')
            ->name('userPendingApps');
        Route::get('/denied', 'ApplicationController@showDeniedUserApps')
            ->name('userDeniedApps');
        Route::get('/approved', 'ApplicationController@showApprovedApps')
            ->name('userApprovedApps');

    });

    Route::group(['prefix' => '/profile'], function (){

        Route::get('/settings', 'ProfileController@index');

    });

    Route::group(['prefix' => '/applications'], function (){

        Route::get('/staff/outstanding', 'ApplicationController@showAllPendingApps')
            ->name('staffPendingApps');

        Route::get('/staff/peer-review', 'ApplicationController@showPeerReview')
            ->name('peerReview');

    });

});

//Route::get('/dashboard/login', '');

