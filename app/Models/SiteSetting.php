<?php

namespace App\Models;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
//    use HasFactory;

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public const SETTING_TRADE_FEE = 'trade-fee';
    public const SETTING_PRICE_LIMIT = 'price-limit';

    protected $fillable = [
        'id', 'setting'
    ];

    protected $casts = [
        'setting'  => 'json'
    ];

    // last edited by
    public function user()
    {
        $this->belongsTo(User::class);
    }

    public static function tradeFee() : SiteSetting
    {
        return Cache::remember('trade-fee-setting', CarbonInterval::minutes(30)->totalSeconds, function () {
            return static::find(SiteSetting::SETTING_TRADE_FEE);
        });
    }

    public static function priceLimit() : SiteSetting
    {
        return Cache::remember('price-limit-setting', CarbonInterval::minutes(30)->totalSeconds, function () {
            return static::find(SiteSetting::SETTING_PRICE_LIMIT);
        });
    }

    public static function bidFeePercent()
    {
        return (static::tradeFee())->setting['bid_percent'];
    }
    public static function askFeePercent()
    {
        return (static::tradeFee())->setting['ask_percent'];
    }

    public static function updateTradeFee($data)
    {
        $tradeFeeSetting = static::find(SiteSetting::SETTING_TRADE_FEE);
        $tradeFeeSetting->setting = [
            'bid_percent' => $data['bid_percent'], // buy percent
            'ask_percent' => $data['ask_percent'], // sale percent
        ];
        $tradeFeeSetting->user_id = auth()->user()->id; // log who edit
        $tradeFeeSetting->save();

        Cache::forget('trade-fee-setting');
    }

    public static function updatePriceLimit($data)
    {
        $priceLimitSetting = static::find(SiteSetting::SETTING_PRICE_LIMIT);
        $priceLimitSetting->setting = [
            'max_bid_price' => $data['max_bid_price'] ? $data['max_bid_price']*100 : null, // max buy price
            'max_ask_price' => $data['max_ask_price'] ? $data['max_ask_price']*100 : null, // max ask price
        ];
        $priceLimitSetting->user_id = auth()->user()->id; // log who edit
        $priceLimitSetting->save();

        Cache::forget('price-limit-setting');
    }
}
