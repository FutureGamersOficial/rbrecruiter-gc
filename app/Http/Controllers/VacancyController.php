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

namespace App\Http\Controllers;

use App\Form;
use App\Http\Requests\VacancyEditRequest;
use App\Http\Requests\VacancyRequest;
use App\Notifications\VacancyClosed;
use App\User;
use App\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VacancyController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Vacancy::class);

        return view('dashboard.administration.positions')
            ->with([
                'forms' => Form::all(),
                'vacancies' => Vacancy::all(),
            ]);
    }

    public function store(VacancyRequest $request)
    {
        $this->authorize('create', Vacancy::class);
        $form = Form::find($request->vacancyFormID);

        if (! is_null($form)) {
            /* note: since we can't convert HTML back to Markdown, we'll have to do the converting when the user requests a page,
            * and leave the database with Markdown only so it can be used and edited everywhere.
            * for several vacancies, this would require looping through all of them and replacing MD with HTML, which is obviously not the most clean solution;
            * however, the Model can be configured to return MD instead of HTML on that specific field saving us from looping.
            */
            Vacancy::create([

                'vacancyName' => $request->vacancyName,
                'vacancyDescription' => $request->vacancyDescription,
                'vacancyFullDescription' => $request->vacancyFullDescription,
                'vacancySlug' => Str::slug($request->vacancyName),
                'permissionGroupName' => $request->permissionGroup,
                'discordRoleID' => $request->discordRole,
                'vacancyFormID' => $request->vacancyFormID,
                'vacancyCount' => $request->vacancyCount,

            ]);

            $request->session()->flash('success', 'Vacancy successfully opened. It will now show in the home page.');
        } else {
            $request->session()->flash('error', 'You cannot create a vacancy without a valid form.');
        }

        return redirect()->back();
    }

    public function updatePositionAvailability(Request $request, $status, Vacancy $vacancy)
    {
        $this->authorize('update', $vacancy);

        if (! is_null($vacancy)) {
            $type = 'success';

            switch ($status) {
                case 'open':
                    $vacancy->open();
                    $message = 'Position successfully opened!';

                    break;

                case 'close':
                    $vacancy->close();
                    $message = 'Position successfully closed!';

                    foreach (User::all() as $user) {
                        if ($user->isStaffMember()) {
                            $user->notify(new VacancyClosed($vacancy));
                        }
                    }
                    break;

                default:
                    $message = "Please do not tamper with the button's URLs. To report a bug, please contact an administrator.";
                    $type = 'error';

            }
        } else {
            $message = "The position you're trying to update doesn't exist!";
            $type = 'error';
        }

        $request->session()->flash($type, $message);

        return redirect()->back();
    }

    public function edit(Request $request, Vacancy $vacancy)
    {
        $this->authorize('update', $vacancy);

        return view('dashboard.administration.editposition')
               ->with('vacancy', $vacancy);
    }

    public function update(VacancyEditRequest $request, Vacancy $vacancy)
    {
        $this->authorize('update', $vacancy);

        $vacancy->vacancyFullDescription = $request->vacancyFullDescription;
        $vacancy->vacancyDescription = $request->vacancyDescription;
        $vacancy->vacancyCount = $request->vacancyCount;

        $vacancy->save();

        $request->session()->flash('success', 'Vacancy successfully updated.');

        return redirect()->back();
    }
}
