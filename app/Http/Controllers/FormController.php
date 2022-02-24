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

use App\Exceptions\EmptyFormException;
use App\Exceptions\FormHasConstraintsException;
use App\Form;
use App\Services\FormManagementService;
use ContextAwareValidator;
use Illuminate\Http\Request;

class FormController extends Controller
{
    private $formService;

    public function __construct(FormManagementService $formService) {
        $this->formService = $formService;
    }

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
        try {
            $form = $this->formService->addForm($request->all());
        }
        catch (EmptyFormException $ex)
        {
            return redirect()
                ->back()
                ->with('exception', $ex->getMessage());
        }

        // Form is boolean or array
        if ($form)
        {
            return redirect()
                ->back()
                ->with('success', __('Form created!'));
        }

        return redirect()
            ->back()
            ->with('errors', $form);
    }

    public function destroy(Request $request, Form $form)
    {
        $this->authorize('delete', $form);
        try {

            $this->formService->deleteForm($form);
            return redirect()
                ->back()
                ->with('success', __('Form deleted successfuly'));

        } catch (FormHasConstraintsException $ex) {

            return redirect()
                ->back()
                ->with('error', $ex->getMessage());

        }
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
        $updatedForm = $this->formService->updateForm($form, $request->all());

        if ($updatedForm instanceof Form) {
            return redirect()->to(route('previewForm', ['form' => $updatedForm->id]));
        }

        // array of errors
        return redirect()
            ->back()
            ->with('errors', $updatedForm);
    }
}
