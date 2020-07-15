<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;

class ContextAwareValidator
{
    /**
    *  The getValidator() method will take an array of fields from the request body, iterates through them,
    *  and dynamically adds validation rules for them. Depending on parameters, it may or may not generate
    *  a form structure for rendering purposes.
    *
    *  This method is mostly meant by internal use by means of static proxies (Facades), in order to reduce code repetition;
    *  Using it outside it's directed scope may cause unexpected results; For instance, the method expects inputs to be in array format, e.g. myFieldNameID1[],
    *  myFieldNameID2[], and so on and so forth.
    *
    *  This isn't checked by the code yet, but if you're implementing it this way in the HTML markup, make sure it's consistent (e.g. use a loop).
    *
    *  P.S This method automatically ignores the CSRF token for validation.
    *
    *  @param array $fields The request form fields
    *  @param bool $generateStructure Whether to incldue a JSON-ready form structure for rendering
    *  @param bool $includeFormName Whether to include formName in the list of validation rules
    *  @return Validator|Collection A validator instance you can use to check for validity, or a Collection with a validator and structure (validator, structure)
    */
    public function getValidator(array $fields, bool $generateStructure = false, bool $includeFormName = false)
    {
        $formStructure = [];
        $validator = [];

        $excludedNames = [
            '_token',
            '_method',
            'formName'
        ];

          if ($includeFormName)
          {
            $validator['formName'] = 'required|string|max:100';
          }

          foreach ($fields as $fieldName => $field)
          {
              if(!in_array($fieldName, $excludedNames))
              {
                  $validator[$fieldName . ".0"] = 'required|string';
                  $validator[$fieldName . ".1"] = 'required|string';

                  if ($generateStructure)
                  {
                    $formStructure['fields'][$fieldName]['title'] = $field[0];
                    $formStructure['fields'][$fieldName]['type'] = $field[1];
                  }

              }
          }

          $validatorInstance = Validator::make($fields, $validator);

          return ($generateStructure) ?
            collect([
              'validator' => $validatorInstance,
              'structure' => json_encode($formStructure)
            ])
            : $validatorInstance;


    }

}
