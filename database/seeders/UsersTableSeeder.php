<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Modules\Users\Models\Users;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Users::firstOrCreate(
            ['email' => 'superadmin@mail.com'],
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'password' => bcrypt('12345678')
            ]
        );
    }
}
