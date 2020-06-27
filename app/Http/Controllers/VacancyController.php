<?php

namespace App\Http\Controllers;

use App\Http\Requests\VacancyRequest;
use App\Vacancy;
use App\User;
use App\Form;

use App\Notifications\VacancyClosed;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class VacancyController extends Controller
{
    public function index()
    {
      $this->authorize('viewAny', Vacancy::class);
        return view('dashboard.administration.positions')
            ->with([
                'forms' => Form::all(),
                'vacancies' => Vacancy::all()
            ]);
    }

    public function store(VacancyRequest $request)
    {
        $this->authorize('create', Vacancy::class);
        $form = Form::find($request->vacancyFormID);

        if (!is_null($form))
        {
            Vacancy::create([

                'vacancyName' => $request->vacancyName,
                'vacancyDescription' => $request->vacancyDescription,
                'vacancySlug' => Str::slug($request->vacancyName),
                'permissionGroupName' => $request->permissionGroup,
                'discordRoleID' => $request->discordRole,
                'vacancyFormID' => $request->vacancyFormID,
                'vacancyCount' => $request->vacancyCount

            ]);

            $request->session()->flash('success', 'Vacancy successfully opened. It will now show in the home page.');
        }
        else
        {
            $request->session()->flash('error', 'You cannot create a vacancy without a valid form.');
        }

        return redirect()->back();

    }

    public function updatePositionAvailability(Request $request, $status, $id)
    {

        $vacancy = Vacancy::find($id);
        $this->authorize('update', $vacancy);

        if (!is_null($vacancy))
        {
            $type = 'success';

            switch ($status)
            {
                case 'open':
                    $vacancy->open();
                    $message = "Position successfully opened!";

                    break;

                case 'close':
                    $vacancy->close();
                    $message = "Position successfully closed!";

                    foreach(User::all() as $user)
                    {
                      if ($user->isStaffMember())
                      {
                        $user->notify(new VacancyClosed($vacancy));
                      }
                    }
                    break;

                default:
                    $message = "Please do not tamper with the button's URLs. To report a bug, please contact an administrator.";
                    $type = 'error';

            }
        }
        else
        {
            $message = "The position you're trying to update doesn't exist!";
            $type = "error";
        }

        $request->session()->flash($type, $message);
        return redirect()->back();
    }

}
