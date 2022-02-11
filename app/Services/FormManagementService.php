<?php


namespace App\Services;

use App\Exceptions\EmptyFormException;
use App\Exceptions\FormHasConstraintsException;
use App\Form;
use ContextAwareValidator;

class FormManagementService
{

    public function addForm($fields) {

        if (count($fields) == 2) {
            // form is probably empty, since forms with fields will always have more than 2 items
            throw new EmptyFormException('Sorry, but you may not create empty forms.');
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
            return true;
        }
        return $contextValidation->get('validator')->errors()->getMessages();
    }

    public function deleteForm(Form $form) {

        $deletable = true;

        if (! is_null($form) && ! is_null($form->vacancies) && $form->vacancies->count() !== 0 || ! is_null($form->responses)) {
            $deletable = false;
        }

        if ($deletable) {

            $form->delete();
            return true;

        } else {

            throw new FormHasConstraintsException(__('You cannot delete this form because it\'s tied to one or more applications and ranks, or because it doesn\'t exist.'));

        }
    }

    public function updateForm(Form $form, $fields) {

        $contextValidation = ContextAwareValidator::getValidator($fields, true);

        if (! $contextValidation->get('validator')->fails()) {
            // Add the new structure into the form. New, subsquent fields will be identified by the "new" prefix
            // This prefix doesn't actually change the app's behavior when it receives applications.
            // Additionally, old applications won't of course display new and updated fields, because we can't travel into the past and get data for them
            $form->formStructure = $contextValidation->get('structure');
            $form->save();

            return $form;

        } else {
            return $contextValidation->get('validator')->errors()->getMessages();
        }
    }

}
