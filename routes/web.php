<?php

/*
 * Copyright © 2020 Miguel Nogueira
 *
 *   This file is part of Raspberry Staff Manager.
 *
 *     Raspberry Staff Manager is free software: you can redistribute it and/or modify
 *     it under the terms of the GNU General Public License as published by
 *     the Free Software Foundation, either version 3 of the License, or
 *     (at your option) any later version.
 *
 *     Raspberry Staff Manager is distributed in the hope that it will be useful,
 *     but WITHOUT ANY WARRANTY; without even the implied warranty of
 *     MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *     GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with Raspberry Staff Manager.  If not, see <https://www.gnu.org/licenses/>.
 */

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {
    Route::group(['prefix' => 'auth', 'middleware' => ['usernameUUID']], function () {
        Auth::routes(['verify' => true]);

        Route::post('/twofa/authenticate', 'Auth\TwofaController@verify2FA')
            ->name('verify2FA');
    });

    Route::get('/', 'HomeController@index')
        ->middleware('eligibility');

    Route::post('/form/contact', 'ContactController@create')
        ->name('sendSubmission');

    Route::group(['middleware' => ['auth', 'forcelogout', '2fa', 'verified']], function () {
        Route::get('/dashboard', 'DashboardController@index')
            ->name('dashboard')
            ->middleware('eligibility');

        Route::get('users/directory', 'ProfileController@index')
            ->name('directory');

        Route::group(['prefix' => '/applications'], function () {
            Route::get('/my-applications', 'ApplicationController@showUserApps')
                ->name('showUserApps')
                ->middleware('eligibility');

            Route::get('/view/{application}', 'ApplicationController@showUserApp')
                ->name('showUserApp');

            Route::post('/{application}/comments', 'CommentController@insert')
                ->name('addApplicationComment');

            Route::delete('/comments/{comment}/delete', 'CommentController@delete')
                ->name('deleteApplicationComment');

            Route::patch('/notes/save/{application}', 'AppointmentController@saveNotes')
                ->name('saveNotes');

            Route::patch('/update/{application}/{newStatus}', 'ApplicationController@updateApplicationStatus')
                ->name('updateApplicationStatus');

            Route::delete('{application}/delete', 'ApplicationController@delete')
                ->name('deleteApplication');

            Route::get('/staff/all', 'ApplicationController@showAllApps')
                ->name('allApplications');

            Route::get('/staff/outstanding', 'ApplicationController@showAllPendingApps')
                ->name('staffPendingApps');

            Route::get('/staff/peer-review', 'ApplicationController@showPeerReview')
                ->name('peerReview');

            Route::get('/staff/pending-interview', 'ApplicationController@showPendingInterview')
                ->name('pendingInterview');

            Route::post('{application}/staff/vote', 'VoteController@vote')
                ->name('voteApplication');
        });

        Route::group(['prefix' => 'appointments'], function () {
            Route::post('schedule/appointments/{application}', 'AppointmentController@saveAppointment')
                ->name('scheduleAppointment');

            Route::patch('update/appointments/{application}/{status}', 'AppointmentController@updateAppointment')
                ->name('updateAppointment');
        });

        Route::group(['prefix' => 'apply', 'middleware' => ['eligibility']], function () {
            Route::get('positions/{vacancySlug}', 'ApplicationController@renderApplicationForm')
                ->name('renderApplicationForm');

            Route::post('positions/{vacancySlug}/submit', 'ApplicationController@saveApplicationAnswers')
                ->name('saveApplicationForm');
        });

        Route::group(['prefix' => '/profile'], function () {
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

            Route::patch('/settings/account/twofa/enable', 'UserController@add2FASecret')
                ->name('enable2FA');

            Route::patch('/settings/account/twofa/disable', 'UserController@remove2FASecret')
                ->name('disable2FA');
        });

        Route::group(['prefix' => '/hr'], function () {
            Route::get('staff-members', 'UserController@showStaffMembers')
                ->name('staffMemberList');

            Route::get('players', 'UserController@showPlayers')
                ->name('registeredPlayerList');

            Route::post('players/search', 'UserController@showPlayersLike')
                ->name('searchRegisteredPLayerList');

            Route::patch('staff-members/terminate/{user}', 'UserController@terminate')
                ->name('terminateStaffMember');
        });

        Route::group(['prefix' => 'admin'], function () {
            Route::get('settings', 'OptionsController@index')
                ->name('showSettings');

            Route::post('settings/save', 'OptionsController@saveSettings')
                ->name('saveSettings');

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

            Route::get('positions/edit/{vacancy}', 'VacancyController@edit')
                ->name('editPosition');

            Route::patch('positions/update/{vacancy}', 'VacancyController@update')
                ->name('updatePosition');

            Route::patch('positions/availability/{status}/{vacancy}', 'VacancyController@updatePositionAvailability')
                ->name('updatePositionAvailability');

            Route::get('forms/builder', 'FormController@showFormBuilder')
                ->name('showFormBuilder');

            Route::post('forms/save', 'FormController@saveForm')
                ->name('saveForm');

            Route::delete('forms/destroy/{form}', 'FormController@destroy')
                ->name('destroyForm');

            Route::get('forms', 'FormController@index')
                ->name('showForms');

            Route::get('forms/preview/{form}', 'FormController@preview')
                ->name('previewForm');

            Route::get('forms/edit/{form}', 'FormController@edit')
                ->name('editForm');

            Route::patch('forms/update/{form}', 'FormController@update')
                ->name('updateForm');

            Route::get('devtools', 'DevToolsController@index')
                ->name('devTools');

            // we could use route model binding
            Route::post('devtools/vote-evaluation/force', 'DevToolsController@forceVoteCount')
                ->name('devToolsForceVoteCount');
        });
    });
});
