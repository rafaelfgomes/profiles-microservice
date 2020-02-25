<?php

use App\Profile as UserProfile;
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
            ['name' => 'Administrador do Sistema', 'uuid' => Uuid::uuid4() ],
            ['name' => 'Gerente', 'uuid' => Uuid::uuid4() ],
            ['name' => 'Vendedor', 'uuid' => Uuid::uuid4() ]
        ];

        UserProfile::create($data);
    }
}
