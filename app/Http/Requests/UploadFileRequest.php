<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
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
            'caption' => 'required|string|max:100',
            'description' => 'required|string|max:800',
            'file' => 'required|file|mimes:jpeg,jpg,png,bmp,tiff,docx,doc,odt,ott,xls,xlsx,ods,ots,gif,pdf,mp3,mp4,pptx,ppt,odp,ppsx,pub,psd,svg'
        ];
    }
}
