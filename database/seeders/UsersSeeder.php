<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdmin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@RMS.com'
        ]);
        $superAdmin->assignRole(Role::SUPER_ADMIN);

        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@RMS.com'
        ]);
        $admin->assignRole(Role::ADMIN);
    }
}
