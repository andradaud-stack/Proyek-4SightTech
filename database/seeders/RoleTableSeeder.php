<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Role\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate(['role' => 'Super Admin'], ['level' => 1]);
        Role::firstOrCreate(['role' => 'Admin'], ['level' => 2]);
    }
}
