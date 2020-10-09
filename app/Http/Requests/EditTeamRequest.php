<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EditTeamRequest extends FormRequest
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
            'teamDescription' => 'required|string|max:200',
            'joinType' => 'required|boolean'
        ];
    }
}
