<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Role\Models\Role;
use App\Modules\Users\Models\Users;
use App\Modules\UserRole\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Users::where('email', 'superadmin@mail.com')->firstOrFail();

        foreach (['Super Admin', 'Admin'] as $roleName) {
            $role = Role::where('role', $roleName)->firstOrFail();
            UserRole::firstOrCreate([
                'id_user' => $user->id,
                'id_role' => $role->id,
            ]);
        }
    }
}
