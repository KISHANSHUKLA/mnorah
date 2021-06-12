<?php

namespace App\Http\Resources;
use App\models\Api\followers;
use App\models\Church;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class RequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   
        $a = new Church;
        return [
            'id' => $this->id,
            'user' => $this->user,
            'church' => $a->churchRecode($this->church_id),
            'invitecode' => $this->invitecodedata,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
           
        ];
    }
}
