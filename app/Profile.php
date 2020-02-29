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

    public static function setFields($data, $method = null)
    {
        $fields = [
            'name' => $data->name,
        ];

        if ($method == 'POST') {
            $fields['uuid'] = Uuid::uuid4();
        }

        return $fields;
    }
}
