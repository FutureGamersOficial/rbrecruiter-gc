<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveSecuritySettings extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'secPolicy' => 'required|string',
            'graceperiod' => 'required|integer',
            'pwExpiry' => 'required|integer',
            'enforce2fa' => 'required|boolean',
            'requirePMC' => 'required|boolean' 
        ];
    }
}
