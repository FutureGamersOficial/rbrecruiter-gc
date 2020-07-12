<?php

namespace App\Http\Controllers;

use App\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{

    public function index()
    {
        $forms = Form::all();
        $this->authorize('viewAny', Form::class);

        return view('dashboard.administration.forms')
            ->with('forms', $forms);
    }

    public function showFormBuilder()
    {
        $this->authorize('viewFormbuilder', Form::class);
        return view('dashboard.administration.formbuilder');
    }

    public function saveForm(Request $request)
    {

        $this->authorize('create', Form::class);

        $formFields = $request->all();

        $formStructure = [];
        $excludedNames = [
            '_token',
            'formName' // It's added outside the loop. Not excluding causes unwanted duplication.
        ];
        $validator = [
            'formName' => 'required|string|max:100'
        ];

        foreach ($formFields as $fieldName => $field)
        {
            if(!in_array($fieldName, $excludedNames))
            {
                $validator[$fieldName . ".0"] = 'required|string';
                $validator[$fieldName . ".1"] = 'required|string';

                $formStructure['fields'][$fieldName]['title'] = $field[0];
                $formStructure['fields'][$fieldName]['type'] = $field[1];
            }
        }

        $validation = Validator::make($formFields, $validator);

        if (!$validation->fails())
        {
            $storableFormStructure = json_encode($formStructure);

            Form::create(
                [
                    'formName' => $formFields['formName'],
                    'formStructure' => $storableFormStructure,
                    'formStatus' => 'ACTIVE'
                ]
            );

            $request->session()->flash('success', 'Form created! You can now link this form to a vacancy.');
            return redirect()->to(route('showForms'));
        }

        $request->session()->flash('errors', $validation->errors()->getMessages());
        return redirect()->back();
    }

    public function destroy(Request $request, $id)
    {

        $form = Form::find($id);
        $this->authorize('delete', $form);
        $deletable = true;


        if (!is_null($form) && !is_null($form->vacancies) && $form->vacancies->count() !== 0 || !is_null($form->responses))
        {
           $deletable = false;
        }
        
        if ($deletable)
        {
          $form->delete();

          $request->session()->flash('success', 'Form deleted successfully.');
        }
        else
        {
          $request->session()->flash('error', 'You cannot delete this form because it\'s tied to one or more applications and ranks, or because it doesn\'t exist.');
        }

        return redirect()->back();

    }

}
