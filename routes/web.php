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

        Route::get('/staff/pending-interview', 'ApplicationController@showPendingInterview')
            ->name('pendingInterview');

    });

    Route::group(['prefix' => '/hr'], function (){

        Route::get('staff-members', 'UserController@showStaffMembers')
            ->name('staffMemberList');

        Route::get('players', 'UserController@showPlayers')
            ->name('registeredPlayerList');

    });

    Route::group(['prefix' => 'admin'], function (){

        Route::resource('positions', 'VacancyController');

        Route::get('forms', 'FormController@index')
            ->name('showFormBuilder');

        Route::post('forms/save', 'FormController@saveForm')
            ->name('saveForm');

    });

});

//Route::get('/dashboard/login', '');

