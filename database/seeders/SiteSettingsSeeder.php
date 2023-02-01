<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;

class SiteSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!SiteSetting::find(SiteSetting::SETTING_TRADE_FEE)) {
            $tradeFeeSetting = new SiteSetting();
            $tradeFeeSetting->id = SiteSetting::SETTING_TRADE_FEE;
            $tradeFeeSetting->setting = [
                'bid_percent' => 2,
                'ask_percent' => 3,
            ];
            $tradeFeeSetting->save();
        }

        if (!SiteSetting::find(SiteSetting::SETTING_PRICE_LIMIT)) {
            $priceLimitSetting = new SiteSetting();
            $priceLimitSetting->id = SiteSetting::SETTING_PRICE_LIMIT;
            $priceLimitSetting->setting = [
                'max_bid_price' => null, // satang
                'max_ask_price' => null, // satang
            ];
            $priceLimitSetting->save();
        }
    }
}
