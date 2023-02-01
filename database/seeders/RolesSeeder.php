<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdminRole = Role::firstOrCreate(['name' => \App\Models\Role::SUPER_ADMIN]);
        $adminRole = Role::firstOrCreate(['name' => \App\Models\Role::ADMIN]);
//        $buyerRole = Role::firstOrCreate(['name' => \App\Models\Role::BUYER]);
//        $sellerRole = Role::firstOrCreate(['name' => \App\Models\Role::SELLER]);
    }
}
