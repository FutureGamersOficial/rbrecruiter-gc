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
use ContextAwareValidator;
use Illuminate\Http\Request;

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
        $fields = $request->all();

        if (count($fields) == 2) {
            // form is probably empty, since forms with fields will alawys have more than 2 items

            $request->session()->flash('error', 'Sorry, but you may not create empty forms.');

            return redirect()->to(route('showForms'));
        }

        $contextValidation = ContextAwareValidator::getValidator($fields, true, true);

        if (! $contextValidation->get('validator')->fails()) {
            $storableFormStructure = $contextValidation->get('structure');

            Form::create(
                [
                    'formName' => $fields['formName'],
                    'formStructure' => $storableFormStructure,
                    'formStatus' => 'ACTIVE',
                ]
            );

            $request->session()->flash('success', 'Form created! You can now link this form to a vacancy.');

            return redirect()->to(route('showForms'));
        }

        $request->session()->flash('errors', $contextValidation->get('validator')->errors()->getMessages());

        return redirect()->back();
    }

    public function destroy(Request $request, Form $form)
    {
        $this->authorize('delete', $form);

        $deletable = true;

        if (! is_null($form) && ! is_null($form->vacancies) && $form->vacancies->count() !== 0 || ! is_null($form->responses)) {
            $deletable = false;
        }

        if ($deletable) {
            $form->delete();

            $request->session()->flash('success', 'Form deleted successfully.');
        } else {
            $request->session()->flash('error', 'You cannot delete this form because it\'s tied to one or more applications and ranks, or because it doesn\'t exist.');
        }

        return redirect()->back();
                
    }

    public function preview(Request $request, Form $form)
    {
        $this->authorize('viewAny', Form::class);

        return view('dashboard.administration.formpreview')
          ->with('form', json_decode($form->formStructure, true))
          ->with('title', $form->formName)
          ->with('formID', $form->id);
    }

    public function edit(Request $request, Form $form)
    {
        $this->authorize('update', $form);

        return view('dashboard.administration.editform')
        ->with('formStructure', json_decode($form->formStructure, true))
        ->with('title', $form->formName)
        ->with('formID', $form->id);
    }

    public function update(Request $request, Form $form)
    {
        $this->authorize('update', $form);

        $contextValidation = ContextAwareValidator::getValidator($request->all(), true);
        $this->authorize('update', $form);

        if (! $contextValidation->get('validator')->fails()) {
            // Add the new structure into the form. New, subsquent fields will be identified by the "new" prefix
            // This prefix doesn't actually change the app's behavior when it receives applications.
            // Additionally, old applications won't of course display new and updated fields, because we can't travel into the past and get data for them
            $form->formStructure = $contextValidation->get('structure');
            $form->save();

            $request->session()->flash('success', 'Hooray! Your form was updated. New applications for it\'s vacancy will use it.');
        } else {
            $request->session()->flash('errors', $contextValidation->get('validator')->errors()->getMessages());
        }

        return redirect()->to(route('previewForm', ['form' => $form->id]));
    }
}
