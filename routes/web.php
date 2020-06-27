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


Route::group(['middleware' => ['auth', 'forcelogout']], function(){

    Route::get('/dashboard', 'DashboardController@index')
        ->name('dashboard')
        ->middleware('eligibility');

    Route::get('users/directory', 'ProfileController@index')
          ->name('directory');

    Route::group(['prefix' => '/applications'], function (){

        Route::get('/my-applications', 'ApplicationController@showUserApps')
            ->name('showUserApps')
            ->middleware('eligibility');


        Route::get('/view/{id}', 'ApplicationController@showUserApp')
            ->name('showUserApp');

        Route::post('/{application}/comments', 'CommentController@insert')
            ->name('addApplicationComment');

        Route::delete('/comments/{comment}/delete', 'CommentController@delete')
            ->name('deleteApplicationComment');


        Route::patch('/notes/save/{applicationID}', 'AppointmentController@saveNotes')
            ->name('saveNotes');


        Route::patch('/update/{id}/{newStatus}', 'ApplicationController@updateApplicationStatus')
            ->name('updateApplicationStatus');

        Route::get('/staff/outstanding', 'ApplicationController@showAllPendingApps')
            ->name('staffPendingApps');

        Route::get('/staff/peer-review', 'ApplicationController@showPeerReview')
            ->name('peerReview');

        Route::get('/staff/pending-interview', 'ApplicationController@showPendingInterview')
            ->name('pendingInterview');


        Route::post('{id}/staff/vote', 'VoteController@vote')
            ->name('voteApplication');


    });

    Route::group(['prefix' => 'appointments'], function (){

        Route::post('schedule/appointments/{applicationID}', 'AppointmentController@saveAppointment')
            ->name('scheduleAppointment');

        Route::patch('update/appointments/{applicationID}/{status}', 'AppointmentController@updateAppointment')
            ->name('updateAppointment');

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

        Route::get('user/{user}', 'ProfileController@showSingleProfile')
            ->name('showSingleProfile');


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

        Route::post('players/search', 'UserController@showPlayersLike')
            ->name('searchRegisteredPLayerList');

        Route::patch('staff-members/terminate/{user}', 'UserController@terminate')
            ->name('terminateStaffMember');

    });

    Route::group(['prefix' => 'admin'], function (){

        Route::post('players/ban/{user}', 'BanController@insert')
            ->name('banUser');

        Route::delete('players/unban/{user}', 'BanController@delete')
            ->name('unbanUser');

        Route::delete('players/delete/{user}', 'UserController@delete')
            ->name('deleteUser');

         Route::patch('players/update/{user}', 'UserController@update')
            ->name('updateUser');



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


        Route::get('devtools', 'DevToolsController@index')
            ->name('devTools');

        // we could use route model binding
        Route::post('devtools/vote-evaluation/force', 'DevToolsController@forceVoteCount')
            ->name('devToolsForceVoteCount');

    });

});

//Route::get('/dashboard/login', '');
