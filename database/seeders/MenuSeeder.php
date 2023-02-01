<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr =     [["Pizza",50.00,"THB"],["Hamburger",150.00,"THB"],["french-fries",75.50,"THB"]];
    foreach( $arr as $i){
        $menu = new Menu();
        $menu->name = $i[0];
        $menu->price = $i[1];
        $menu->unit = $i[2];
        $menu->save();
    }


    }
}
