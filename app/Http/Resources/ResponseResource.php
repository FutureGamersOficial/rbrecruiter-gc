<?php

namespace App\Http\Resources;

use App\Form;
use App\Vacancy;
use Illuminate\Http\Resources\Json\JsonResource;

class ResponseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'form' => new FormResource(Form::findOrFail($this->responseFormID)),
            'responseData' => json_decode($this->responseData),
            'vacancy' => new VacancyResource(Vacancy::findOrFail($this->associatedVacancyID)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
