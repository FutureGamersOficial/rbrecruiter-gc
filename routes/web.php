<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AppointmentController;
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
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacancyController;
use App\Http\Controllers\VoteController;
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
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function (){

    Route::group(['prefix' => 'auth', 'middleware' => ['usernameUUID']], function (){

        Auth::routes(['verify' => true]);

        Route::post('/twofa/authenticate', [TwofaController::class, 'verify2FA'])
            ->name('verify2FA');

    });

    Route::get('/', [HomeController::class, 'index'])
        ->middleware('eligibility');

    Route::post('/form/contact', [ContactController::class, 'create'])
        ->name('sendSubmission');

    Route::get('/accounts/danger-zone/{ID}/{action}/{token}', [UserController::class, 'processDeleteConfirmation'])
        ->name('processDeleteConfirmation');


    Route::group(['middleware' => ['auth', 'forcelogout', '2fa', 'verified']], function(){

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

    

        Route::group(['prefix' => '/applications'], function (){

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


            Route::get('/staff/outstanding', [ApplicationController::class, 'showAllPendingApps'])
                ->name('staffPendingApps');


            Route::get('/staff/peer-review', [ApplicationController::class, 'showPeerReview'])
                ->name('peerReview');


            Route::get('/staff/pending-interview', [ApplicationController::class, 'showPendingInterview'])
                ->name('pendingInterview');



            Route::post('{application}/staff/vote', [VoteController::class, 'vote'])
                ->name('voteApplication');


        });

        Route::group(['prefix' => 'appointments'], function (){

            Route::post('schedule/appointments/{application}', [AppointmentController::class, 'saveAppointment'])
                ->name('scheduleAppointment');

            Route::patch('update/appointments/{application}/{status}', [AppointmentController::class, 'updateAppointment'])
                ->name('updateAppointment');

        });

        Route::group(['prefix' => 'apply', 'middleware' => ['eligibility']], function (){

            Route::get('positions/{vacancySlug}', [ApplicationController::class, 'renderApplicationForm'])
                ->name('renderApplicationForm');

            Route::post('positions/{vacancySlug}/submit', [ApplicationController::class, 'saveApplicationAnswers'])
                ->name('saveApplicationForm');

        });

        Route::group(['prefix' => '/profile'], function (){

            Route::get('/settings', [ProfileController::class, 'showProfile'])
                ->name('showProfileSettings');

            Route::patch('/settings/save', [ProfileController::class, 'saveProfile'])
                ->name('saveProfileSettings');

            Route::get('user/{user}', [ProfileController::class, 'showSingleProfile'])
                ->name('showSingleProfile');


            Route::get('/settings/account', [UserController::class, 'showAccount'])
                ->name('showAccountSettings');


            Route::patch('/settings/account/change-password', [UserController::class, 'changePassword'])
                ->name('changePassword');

            Route::patch('/settings/account/change-email', [UserController::class, 'changeEmail'])
                ->name('changeEmail');

            Route::post('/settings/account/flush-sessions', [UserController::class, 'flushSessions'])
                ->name('flushSessions');

            Route::patch('/settings/account/twofa/enable', [UserController::class, 'add2FASecret'])
                ->name('enable2FA');

            Route::patch('/settings/account/twofa/disable', [UserController::class, 'remove2FASecret'])
                ->name('disable2FA');

            Route::patch('/settings/account/dg/delete', [UserController::class, 'userDelete'])
                ->name('userDelete');

        });


        Route::group(['prefix' => '/hr'], function (){

            Route::get('staff-members', [UserController::class, 'showStaffMembers'])
                ->name('staffMemberList');

            Route::get('players', [UserController::class, 'showPlayers'])
                ->name('registeredPlayerList');

            Route::post('players/search', [UserController::class, 'showPlayersLike'])
                ->name('searchRegisteredPLayerList');

            Route::patch('staff-members/terminate/{user}', [UserController::class, 'terminate'])
                ->name('terminateStaffMember');

        });

        Route::group(['prefix' => 'admin'], function (){

            Route::get('settings', [OptionsController::class, 'index'])
                ->name('showSettings');

            Route::post('settings/save', [OptionsController::class, 'saveSettings'])
                ->name('saveSettings');

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


            Route::get('devtools', [DevToolsController::class, 'index'])
                ->name('devTools');

            // we could use route model binding
            Route::post('devtools/vote-evaluation/force', [DevToolsController::class, 'forceVoteCount'])
                ->name('devToolsForceVoteCount');

        });

    });
});


