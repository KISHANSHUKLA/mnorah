<?php

namespace App\Http\Resources;

use App\models\Api\events;
use App\models\Api\likes;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class EventlistResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   
        $a = new likes;
        $b = new events;
        return [
            'id' => $this->id,
            'user' => $b->userget($this->user_id),
            'message' => $this->message,
            'image' => URL::to('/').''.$this->image,
            'status' => $this->status,
            'islike' => $a->like($this->id),
            'like_count' => $a->likecount($this->id),
            'iscomment' => $a->comment($this->id),
            'comment_count' => $a->commentcount($this->id),
            'iswitness' => $a->witness($this->id),
            'witness_count'=> $a->witnesscount($this->id),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
        ];
    }
}
