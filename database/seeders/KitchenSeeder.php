<?php

namespace Database\Seeders;

use App\Models\Kitchen;
use Illuminate\Database\Seeder;

class KitchenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kitchen1 = new Kitchen();
        $kitchen1->name = "room_1";
        $kitchen1->is_active = 1;
        $kitchen1->save();

        $kitchen2 = new Kitchen();
        $kitchen2->name = "room_2";
        $kitchen2->is_active = 1;
        $kitchen2->save();

        $kitchen2 = new Kitchen();
        $kitchen2->name = "room_3";
        $kitchen2->is_active = 1;
        $kitchen2->save();
    }
}
