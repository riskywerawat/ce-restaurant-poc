<?php

namespace Database\Seeders;

use App\Models\OrderRequest;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrderRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr =     [[1],[2]];
        foreach ($arr as $i) {
            $menu = new OrderRequest();
            $menu->kitchen_id = $i[0];
            $menu->save();
        }
    }
}
