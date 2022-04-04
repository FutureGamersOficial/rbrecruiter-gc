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

use App\Http\Controllers\AbsenceController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\TwofaController;
use App\Http\Controllers\BanController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DevToolsController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamFileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\OptionsController;
use App\Http\Controllers\SecuritySettingsController;
use Illuminate\Support\Facades\Log;
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

Route::get('/uptime', function () {

    return response()->json([
        'app' => config('app.name'),
        'status' => 'up',
        'version' => '0.7.2',
        'meta' => [
            'demo_enabled' => config('demo.is_enabled'),
        ]
    ]);

})->name('uptime');

Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {
    Route::group(['prefix' => 'auth', 'middleware' => ['usernameUUID']], function () {
        Auth::routes([
            'verify' => true
        ]);

        Route::post('/twofa/authenticate', [TwofaController::class, 'verify2FA'])
            ->name('verify2FA');


        Route::get('/auth/redirect/discord', [LoginController::class, 'discordRedirect'])
            ->name('discordRedirect');

        Route::get('/auth/callback/discord', [LoginController::class, 'discordCallback'])
            ->name('discordCallback');

    });

    Route::get('/', [HomeController::class, 'index'])
        ->name('home')
        ->middleware('eligibility');


    Route::post('/form/contact', [ContactController::class, 'create'])
        ->name('sendSubmission');

    Route::get('/accounts/{accountID}/dg/process-delete/{action}', [UserController::class, 'processDeleteConfirmation'])
        ->name('processDeleteConfirmation');

    Route::group(['middleware' => ['auth', 'forcelogout', 'passwordexpiration', '2fa', 'verified']], function () {



        Route::group(['middleware' => ['passwordredirect']], function(){

            Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard')
            ->middleware('eligibility');

            Route::get('users/directory', [ProfileController::class, 'index'])
                ->name('directory');

            Route::resource('teams', TeamController::class);

            Route::post('teams/{team}/invites/send', [TeamController::class, 'invite'])
                    ->name('sendInvite');

            Route::get('teams/{team}/switch', [TeamController::class, 'switchTeam'])
                    ->name('switchTeam');

            Route::patch('teams/{team}/vacancies/update', [TeamController::class, 'assignVacancies'])
                    ->name('assignVacancies');

            Route::get('teams/invites/{action}/{token}', [TeamController::class, 'processInviteAction'])
                ->name('processInvite');



            Route::get('team/files', [TeamFileController::class, 'index'])
                ->name('showTeamFiles');

            Route::post('team/files/upload', [TeamFileController::class, 'store'])
                ->name('uploadTeamFile');

            Route::delete('team/files/{teamFile}/delete', [TeamFileController::class, 'destroy'])
                ->name('deleteTeamFile');

            Route::get('team/files/{teamFile}/download', [TeamFileController::class, 'download'])
                ->name('downloadTeamFile');

        });

        Route::group(['prefix' => '/applications', 'middleware' => ['passwordredirect']], function () {
            Route::get('/my-applications', [ApplicationController::class, 'showUserApps'])
                ->name('showUserApps')
                ->middleware('eligibility');

            Route::get('/view/{application}', [ApplicationController::class, 'showUserApp'])
                ->name('showUserApp');

            Route::post('/{application}/comments', [CommentController::class, 'insert'])
                ->name('addApplicationComment');

            Route::delete('/comments/{comment}/delete', [CommentController::class, 'delete'])
                ->name('deleteApplicationComment');

            Route::patch('/notes/save/{application}', [AppointmentController::class, 'saveNotes'])
                ->name('saveNotes');

            Route::patch('/update/{application}/{newStatus}', [ApplicationController::class, 'updateApplicationStatus'])
                ->name('updateApplicationStatus');

            Route::delete('{application}/delete', [ApplicationController::class, 'delete'])
                ->name('deleteApplication');

            Route::get('/staff/all', [ApplicationController::class, 'showAllApps'])
                ->name('allApplications');


            Route::post('{application}/staff/vote', [VoteController::class, 'vote'])
                ->name('voteApplication');
        });

        Route::group(['prefix' => 'appointments', 'middleware' => ['passwordredirect']], function () {
            Route::post('schedule/appointments/{application}', [AppointmentController::class, 'saveAppointment'])
                ->name('scheduleAppointment');

            Route::patch('update/appointments/{application}/{status}', [AppointmentController::class, 'updateAppointment'])
                ->name('updateAppointment');

            Route::delete('delete/appointments/{application}', [AppointmentController::class, 'deleteAppointment'])
                ->name('deleteAppointment');
        });

        Route::group(['prefix' => 'apply', 'middleware' => ['eligibility', 'passwordredirect']], function () {
            Route::get('positions/{vacancySlug}', [ApplicationController::class, 'renderApplicationForm'])
                ->name('renderApplicationForm');

            Route::post('positions/{vacancySlug}/submit', [ApplicationController::class, 'saveApplicationAnswers'])
                ->name('saveApplicationForm');
        });

        // Further locking down the profile section by adding the middleware to everything but the required routes
        Route::group(['prefix' => '/profile'], function () {
            Route::get('/settings', [ProfileController::class, 'showProfile'])
                ->name('showProfileSettings')
                ->middleware('passwordredirect');

            Route::patch('/settings/save', [ProfileController::class, 'saveProfile'])
                ->name('saveProfileSettings')
                ->middleware('passwordredirect');

            Route::get('user/{user}', [ProfileController::class, 'showSingleProfile'])
                ->name('showSingleProfile')
                ->middleware('passwordredirect');



            Route::get('/settings/account', [UserController::class, 'showAccount'])
                ->name('showAccountSettings');


            Route::patch('/settings/account/change-password', [UserController::class, 'changePassword'])
                ->name('changePassword');



            Route::patch('/settings/account/change-email', [UserController::class, 'changeEmail'])
                ->name('changeEmail')
                ->middleware('passwordredirect');

            Route::post('/settings/account/flush-sessions', [UserController::class, 'flushSessions'])
                ->name('flushSessions')
                ->middleware('passwordredirect');

            Route::patch('/settings/account/twofa/enable', [UserController::class, 'add2FASecret'])
                ->name('enable2FA')
                ->middleware('passwordredirect');

            Route::patch('/settings/account/twofa/disable', [UserController::class, 'remove2FASecret'])
                ->name('disable2FA')
                ->middleware('passwordredirect');

            Route::patch('/settings/account/dg/delete', [UserController::class, 'userDelete'])
                ->name('userDelete')
                ->middleware('passwordredirect');
        });

        Route::group(['prefix' => '/hr', 'middleware' => ['passwordredirect']], function () {

            Route::get('users', [UserController::class, 'showUsers'])
                ->name('registeredPlayerList');

            Route::post('players/search', [UserController::class, 'showPlayersLike'])
                ->name('searchRegisteredPLayerList');

            Route::patch('staff-members/terminate/{user}', [UserController::class, 'terminate'])
                ->name('terminateStaffMember');



            Route::resource('absences', AbsenceController::class);

            Route::controller(AbsenceController::class)->group(function () {

                Route::get('my-absences', 'showUserAbsences')
                    ->name('showUserAbsences');

                Route::patch('absences/{absence}/approve', 'approveAbsence')
                    ->name('approveAbsence');

                Route::patch('absences/{absence}/decline', 'declineAbsence')
                    ->name('declineAbsence');

                Route::patch('absences/{absence}/cancel', 'cancelAbsence')
                    ->name('cancelAbsence');

            });

        });

        Route::group(['prefix' => 'admin', 'middleware' => ['passwordredirect']], function () {
            Route::get('settings', [OptionsController::class, 'index'])
                ->name('showSettings');


            Route::post('settings/save', [OptionsController::class, 'saveSettings'])
                ->name('saveSettings');

            Route::post('settings/security/save', [SecuritySettingsController::class, 'save'])
                ->name('saveSecuritySettings');

            Route::patch('settings/game/update', [OptionsController::class, 'saveGameIntegration'])
                ->name('saveGameIntegration');

            Route::post('players/ban/{user}', [BanController::class, 'insert'])
                ->name('banUser');

            Route::delete('players/unban/{user}', [BanController::class, 'delete'])
                ->name('unbanUser');

            Route::delete('players/delete/{user}', [UserController::class, 'delete'])
                ->name('deleteUser');

            Route::patch('players/update/{user}', [UserController::class, 'update'])
                ->name('updateUser');

            Route::get('positions', [VacancyController::class, 'index'])
                ->name('showPositions');

            Route::post('positions/save', [VacancyController::class, 'store'])
                ->name('savePosition');

            Route::get('positions/edit/{vacancy}', [VacancyController::class, 'edit'])
                ->name('editPosition');

            Route::patch('positions/update/{vacancy}', [VacancyController::class, 'update'])
                ->name('updatePosition');

            Route::delete('positions/delete/{vacancy}', [VacancyController::class, 'delete'])
                ->name('deletePosition');

            Route::patch('positions/availability/{status}/{vacancy}', [VacancyController::class, 'updatePositionAvailability'])
                ->name('updatePositionAvailability');

            Route::get('forms/builder', [FormController::class, 'showFormBuilder'])
                ->name('showFormBuilder');

            Route::post('forms/save', [FormController::class, 'saveForm'])
                ->name('saveForm');

            Route::delete('forms/destroy/{form}', [FormController::class, 'destroy'])
                ->name('destroyForm');

            Route::get('forms', [FormController::class, 'index'])
                ->name('showForms');

            Route::get('forms/preview/{form}', [FormController::class, 'preview'])
                ->name('previewForm');

            Route::get('forms/edit/{form}', [FormController::class, 'edit'])
                ->name('editForm');

            Route::patch('forms/update/{form}', [FormController::class, 'update'])
                ->name('updateForm');


            Route::group(['prefix' => 'devtools'], function () {

                Route::get('/', [DevToolsController::class, 'index'])
                    ->name('devTools');


                Route::post('/applications/force-approval', [DevToolsController::class, 'forceApprovalEvent'])
                    ->name('devForceApprovalEvent');

                Route::post('/applications/force-rejection', [DevToolsController::class, 'forceRejectionEvent'])
                    ->name('devForceRejectionEvent');

                Route::post('/applications/count-votes', [DevToolsController::class, 'evaluateVotes'])
                    ->name('devForceEvaluateVotes');

                Route::delete('/suspensions/purge-expired', [DevToolsController::class, 'purgeSuspensions'])
                    ->name('devPurgeExpiredSuspensions');

                Route::delete('/absences/purge-expired', [DevToolsController::class, 'endAbsencesNow'])
                    ->name('devPurgeExpiredAbsences');

            });

        });
    });
});
