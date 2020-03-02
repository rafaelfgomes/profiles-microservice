<?php

namespace App;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'uuid',
    ];

    public static function validationRules($method = null)
    {
        $rules = [
            'name' => 'required|string'
        ];

        return $rules;
    }

    public static function setFields($data, $method = null)
    {
        $fields = [
            'name' => $data->name,
        ];

        $fields['uuid'] = ($method == 'POST') ? Uuid::uuid4() : $data->uuid;

        return $fields;
    }

    public static function getProfilesLinks($id)
    {
        $url = env('APP_URL') . ':' . env('APP_PORT');
        $profilesEndpoint = '/profiles';
        return $url . $profilesEndpoint . "/{$id}";
    }

}
