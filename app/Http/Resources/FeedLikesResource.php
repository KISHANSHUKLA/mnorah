<?php

namespace App\Http\Resources;

use App\models\Api\events;
use App\models\Api\likes;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class FeedLikesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $b = new events;
        return [
            'id' => $this->id,
            'user' => $b->userget($this->user_id),
            'event_id' => $b->event($this->event_id),
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
        ];
    }
}
