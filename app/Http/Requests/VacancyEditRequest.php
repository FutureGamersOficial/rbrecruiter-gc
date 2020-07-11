<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class VacancyEditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('admin.hiring.vacancy.edit');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'vacancyDescription' => 'required|string',
            'vacancyFullDescription' => 'nullable|string',
            'vacancyCount' => 'required|integer|min:1'
        ];
    }
}
