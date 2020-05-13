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

Route::group(['prefix' => 'auth', 'middleware' => ['usernameUUID']], function (){

    Auth::routes();

});

Route::get('/','HomeController@index')
    ->middleware('eligibility');

Route::post('/form/contact', 'ContactController@create')
    ->name('sendSubmission');


Route::group(['middleware' => 'auth'], function(){

    Route::get('/dashboard', 'DashboardController@index')
        ->name('dashboard')
        ->middleware('eligibility');

    Route::group(['prefix' => '/applications'], function (){

        Route::get('/current', 'ApplicationController@showUserApps')
            ->name('showUserApps')
            ->middleware('eligibility');


        Route::get('/staff/outstanding', 'ApplicationController@showAllPendingApps')
            ->name('staffPendingApps');

        Route::get('/staff/peer-review', 'ApplicationController@showPeerReview')
            ->name('peerReview');

        Route::get('/staff/pending-interview', 'ApplicationController@showPendingInterview')
            ->name('pendingInterview');


    });

    Route::group(['prefix' => 'apply', 'middleware' => ['eligibility']], function (){

        Route::get('positions/{vacancySlug}', 'ApplicationController@renderApplicationForm')
            ->name('renderApplicationForm');

        Route::post('positions/{vacancySlug}/submit', 'ApplicationController@saveApplicationAnswers')
            ->name('saveApplicationForm');

    });

    Route::group(['prefix' => '/profile'], function (){

        Route::get('/settings', 'ProfileController@showProfile')
            ->name('showProfileSettings');

        Route::patch('/settings/save', 'ProfileController@saveProfile')
            ->name('saveProfileSettings');



        Route::get('/settings/account', 'UserController@showAccount')
            ->name('showAccountSettings');


        Route::patch('/settings/account/change-password', 'UserController@changePassword')
            ->name('changePassword');

        Route::patch('/settings/account/change-email', 'UserController@changeEmail')
            ->name('changeEmail');

        Route::post('/settings/account/flush-sessions', 'UserController@flushSessions')
            ->name('flushSessions');

    });


    Route::group(['prefix' => '/hr'], function (){

        Route::get('staff-members', 'UserController@showStaffMembers')
            ->name('staffMemberList');

        Route::get('players', 'UserController@showPlayers')
            ->name('registeredPlayerList');

    });

    Route::group(['prefix' => 'admin'], function (){

        Route::get('positions', 'VacancyController@index')
            ->name('showPositions');

        Route::post('positions/save', 'VacancyController@store')
            ->name('savePosition');


        Route::patch('positions/availability/{status}/{id}', 'VacancyController@updatePositionAvailability')
            ->name('updatePositionAvailability');


        Route::get('forms/builder', 'FormController@showFormBuilder')
            ->name('showFormBuilder');

        Route::post('forms/save', 'FormController@saveForm')
            ->name('saveForm');

        Route::delete('forms/destroy/{id}', 'FormController@destroy')
            ->name('destroyForm');

        Route::get('forms', 'FormController@index')
            ->name('showForms');

    });

});

//Route::get('/dashboard/login', '');

