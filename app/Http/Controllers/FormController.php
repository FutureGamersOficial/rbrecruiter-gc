<?php

namespace App\Http\Controllers;

use App\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{

    public function index()
    {

    }

    public function showFormBuilder()
    {
        return view('dashboard.administration.formbuilder');
    }

    public function saveForm(Request $request)
    {

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
            return redirect()->back();
        }

        $request->session()->flash('errors', $validation->errors()->getMessages());
        return redirect()->back();
    }

}
