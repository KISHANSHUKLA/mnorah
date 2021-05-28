<?php

namespace App\Http\Resources;
use App\models\Api\followers;
use Illuminate\Http\Resources\Json\JsonResource;

class AppChurchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   
        $a = new followers;
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'location' => $this->location,
            'denomination' => $this->denomination,
            'venue' => $this->venue,
            'days' => json_decode($this->days),
            'language' => $this->language,
            'Social' =>$this->Social,
            'vision' =>$this->vision,
            'isfollow' => $a->followget($this->id),
            'leadership'=> $this->leadership,
            'ministries'=> $this->ministries,
            'event'=> $this->event,
            'eventimage'=> json_decode($this->eventimage),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
           
        ];
    }
}
