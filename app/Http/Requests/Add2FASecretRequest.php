<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Add2FASecretRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       // current logic only updates currently authenticated user
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
            'otp' => 'required|string|min:6|max:6'
        ];
    }
}
