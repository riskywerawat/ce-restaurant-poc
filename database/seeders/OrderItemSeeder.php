<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $arr =     [[1,3,2],[1,2,1]];
        foreach ($arr as $i) {
            $items = new OrderItem();
            $items->order_request_id = $i[0];
            $items->menu_id = $i[1];
            $items->quantity = $i[2];

            $items->save();
        }
    }
}
