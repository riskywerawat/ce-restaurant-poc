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
        $arr =     [[1],[1], [2],[2],[3],[3]];
        foreach ($arr as $i) {
            $menu = new OrderRequest();
            $menu->kitchen_id = $i[0];
            $menu->order_time = Carbon::now();
            $menu->save();
        }
    }
}
