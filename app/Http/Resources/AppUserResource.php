<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AppUserResource extends JsonResource
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
            'name' => $this->user->name,
            'email' => $this->user->email,
            'json' => $this->name,
            'login_type' => $this->usertype,
            'Leadershipteam' => $this->Leadershipteam,
            'medicallyverified' =>$this->medicallyverified,
            'communityverified' =>$this->communityverified,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
