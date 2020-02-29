<?php

namespace App\Http\Resources;

use App\Profile as UserProfile;
use Illuminate\Http\Resources\Json\Resource;

class Profile extends Resource
{

    /**
     * Transform the resource into an array.
     *
     * @param Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);

        return [
            'type' => 'profiles',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'uuid' => $this->uuid
            ],
            'links' => [
                'self' => UserProfile::getProfilesLinks($this->id)
            ]
        ];
    }

    public function with($request)
    {
        return [
            'Teste' => 'sssss'
        ];
    }

}
