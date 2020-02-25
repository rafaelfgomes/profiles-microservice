<?php

use App\Profile as UserProfile;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Administrador do Sistema',
                'uuid' => Uuid::uuid4(),
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Gerente',
                'uuid' => Uuid::uuid4(),
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Vendedor',
                'uuid' => Uuid::uuid4(),
                'created_at' => Carbon::now()
            ]

        ];

        UserProfile::insert($data);
    }
}
