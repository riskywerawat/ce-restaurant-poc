<?php

namespace App\Console\Commands;

use App\Events\MarketDataUpdated;
use App\Models\AskRequest;
use App\Models\BidRequest;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class CheckOfferExpireCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'offers:check-expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check bid and requests for delivery date expiration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
//        $date = (new Carbon('Asia/Bangkok'))->addDays(config('rms.start_days') - 1); // first day that can trade - 1 = day to expire active offers
        $date = (new Carbon('Asia/Bangkok'))->addDays(config('rms.start_days'));

        $bids = BidRequest::active()->where('delivery_date', '<=', $date->format('Y-m-d'))->get();
        foreach ($bids as $bid) {
            if ($bid->quantity_matched > 0) { // partial matched
                $bid->status = BidRequest::STATUS_MATCHED;
                $bid->quantity = $bid->quantity_matched;
                $bid->quantity_pending = 0;
            } else { // no match
                $bid->status = BidRequest::STATUS_EXPIRED;
            }
            $bid->save();
        }

        $asks = AskRequest::active()->where('delivery_date', '<=', $date->format('Y-m-d'))->get();
        foreach ($asks as $ask) {
            if ($ask->quantity_matched > 0) { // partial matched
                $ask->status = AskRequest::STATUS_MATCHED;
                $ask->quantity = $ask->quantity_matched;
                $ask->quantity_pending = 0;
            } else { // no match
                $ask->status = AskRequest::STATUS_EXPIRED;
            }
            $ask->save();
        }

        Cache::forget('market');
        broadcast(new MarketDataUpdated(['success' => true, 'time' => (new Carbon())->timestamp]));
    }
}
