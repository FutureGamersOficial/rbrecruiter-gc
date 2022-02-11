<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;


class StoreAbsenceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->hasPermissionTo('reviewer.requestAbsence');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'reason' => 'required|string',
            'start_date' => 'required|date',
            'predicted_end' => 'required|date|after:start_date',
            'available_assist' => 'required|string',
            'invalidAbsenceAgreement' => 'required|accepted'
        ];
    }
}
