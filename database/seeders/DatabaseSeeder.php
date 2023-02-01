<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use App\Models\OrderRequest;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(SiteSettingsSeeder::class);
        $this->call(KitchenSeeder::class);
        $this->call(MenuSeeder::class);
        $this->call(OrderRequestSeeder::class);
         $this->call(OrderItemSeeder::class);
    }
}
