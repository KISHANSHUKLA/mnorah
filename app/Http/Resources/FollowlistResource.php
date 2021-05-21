<?php

namespace App\Http\Resources;

use App\models\Church;
use Illuminate\Http\Resources\Json\JsonResource;

class FollowlistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

        $a = new Church();
        return [
            'id' => $this->id,
            'follower_id' => $this->follower_id,
            'church' => $a->churchRecode($this->church_id),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
    
}
