<?php

namespace App\Http\Resources;

use App\Response;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
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
            'applicationStatus' => $this->applicationStatus,
            'applicant' => new UserResource(User::findOrFail($this->applicantUserID)),
            'response' => new ResponseResource(Response::findOrFail($this->applicantFormResponseID)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
