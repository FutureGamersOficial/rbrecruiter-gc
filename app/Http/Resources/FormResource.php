<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormResource extends JsonResource
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
            'formName' => $this->formName,
            'formStructure' => json_decode($this->formStructure),
            'formStatus' => $this->formStatus,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
