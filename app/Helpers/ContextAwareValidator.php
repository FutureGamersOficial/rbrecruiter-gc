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

namespace App\Helpers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class ContextAwareValidator
{
    /**
     * The excludedNames array will make the validator ignore any of these names when including names into the rules.
     * @var array
     */
    private $excludedNames = [
        '_token',
        '_method',
        'formName',
    ];

    /**
     * Utility wrapper for json_encode.
     *
     * @param array $value The array to be converted.
     * @return string The JSON representation of $value
     */
    private function encode(array $value): string
    {
        return json_encode($value);
    }

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

        if ($includeFormName) {
            $validator['formName'] = 'required|string|max:100';
        }

        foreach ($fields as $fieldName => $field) {
            if (! in_array($fieldName, $this->excludedNames)) {
                $validator[$fieldName.'.0'] = 'required|string';
                $validator[$fieldName.'.1'] = 'required|string';

                if ($generateStructure) {
                    $formStructure['fields'][$fieldName]['title'] = $field[0];
                    $formStructure['fields'][$fieldName]['type'] = $field[1];
                }
            }
        }

        $validatorInstance = Validator::make($fields, $validator);

        return ($generateStructure) ?
            collect([
                'validator' => $validatorInstance,
                'structure' => $this->encode($formStructure),
            ])
            : $validatorInstance;
    }

    /**
     * The getResponseValidator method is similar to the getValidator method; It basically takes
     * an array of fields from a previous form (that probably went through the other method) and adds validation
     * to the field names.
     *
     * Also generates the storable response structure if you tell it to.
     *
     * @param array $fields The received fields
     * @param array $formStructure The form structure - You must supply this if you want the response structure
     * @param bool  $generateResponseStructure Whether to generate the response structure
     * @return Validator|Collection A collection or a validator, depending on the args. Will return validatior if only fields are supplied.
     */
    public function getResponseValidator(array $fields, array $formStructure = [], bool $generateResponseStructure = true)
    {
        $responseStructure = [];
        $validator = [];

        if (empty($formStructure) && $generateResponseStructure) {
            throw new \InvalidArgumentException('Illegal combination of arguments supplied! Please check the method\'s documentation.');
        }

        foreach ($fields as $fieldName => $value) {
            if (! in_array($fieldName, $this->excludedNames)) {
                $validator[$fieldName] = 'required|string';

                if ($generateResponseStructure) {
                    $responseStructure['responses'][$fieldName]['type'] = $formStructure['fields'][$fieldName]['type'] ?? 'Unavailable';
                    $responseStructure['responses'][$fieldName]['title'] = $formStructure['fields'][$fieldName]['title'];
                    $responseStructure['responses'][$fieldName]['response'] = $value;
                }
            }
        }

        $validatorInstance = Validator::make($fields, $validator);

        return ($generateResponseStructure) ?
        collect([
            'validator' => $validatorInstance,
            'responseStructure' => $this->encode($responseStructure),
        ])
        : $validatorInstance;
    }
}
