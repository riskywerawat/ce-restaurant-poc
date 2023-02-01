<?php

namespace App\Http\Controllers;

use App\Events\MarketDataUpdated;
use App\Http\Requests\CreateBidRequest;
use App\Models\AskRequest;
use App\Models\BidRequest;
use App\Models\SiteSetting;
use App\Models\Transaction;
use App\Transformers\BidRequestTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class BidRequestController extends Controller
{
    public function store(CreateBidRequest $request)
    {
        $this->authorize('create', BidRequest::class);

        $user = $request->user();

        $dates = $request->delivery_date;

        $priceSatang = $request->price * 100; // Baht to Satang
        $bidRequests = [];
        $now = new Carbon();

        DB::beginTransaction();
        try {
            $askRequests = AskRequest::active()
                ->where('price', '<=' , $priceSatang)
                ->whereIn('delivery_date', $dates)
                ->lockForUpdate() // prevent other request from select same ask requests
                ->get();

            foreach ($dates as $date) {

                $askRequestsSameDay = $askRequests->filter(function ($value, $key) use($date) {
                    return $value->delivery_date->format('Y-m-d') == $date;
                })->sort(function ($a, $b) {
                    if ($a->price === $b->price) { // if same price order by created at
                        return $a->created_at <=> $b->created_at;
                    }
                    return $a->price <=> $b->price;
                });

                // temporary create bid for each day
                $bidRequest = new BidRequest();
                $bidRequest->user_id = $user->id;
                $bidRequest->status = BidRequest::STATUS_ACTIVE;
                $bidRequest->delivery_date = $date;
                $bidRequest->quantity = $request->quantity;
                $bidRequest->quantity_matched = 0;
                $bidRequest->quantity_pending = $request->quantity;
                $bidRequest->price = $priceSatang;
                $bidRequest->fee = SiteSetting::bidFeePercent();
                $bidRequest->created_at = $now;
                $bidRequest->updated_at = $now;
                $bidRequest->save();

                foreach ($askRequestsSameDay as $askRequest) {
                    if ($bidRequest->quantity_pending <= 0) { // fully matched
                        break;
                    }

                    // found matched
                    $quantityMatched = min($askRequest->quantity_pending, $bidRequest->quantity_pending);
                    $priceMatchedSatang = min($priceSatang, $askRequest->price);
                    $askRequest->quantity_matched += $quantityMatched;
                    $askRequest->quantity_pending -= $quantityMatched;
                    if ($askRequest->quantity_pending == 0) {
                        $askRequest->status = AskRequest::STATUS_MATCHED;
                    }
                    $askRequest->save();

                    $bidRequest->quantity_matched += $quantityMatched;
                    $bidRequest->quantity_pending -= $quantityMatched;

                    // create new transaction
                    $transaction = new Transaction();
                    $transaction->bid_request_id = $bidRequest->id;
                    $transaction->ask_request_id = $askRequest->id;
                    $transaction->delivery_date = $date;
                    $transaction->quantity = $quantityMatched;
                    $transaction->price = $priceMatchedSatang;
                    $transaction->bid_fee = $bidRequest->fee;
                    $transaction->ask_fee = $askRequest->fee;
                    $transaction->buyer_spend = $transaction->present()->buyerSpend; // for record
                    $transaction->seller_received = $transaction->present()->sellerReceived; // for record
                    $transaction->save();
                }

                if ($bidRequest->quantity_pending <= 0) {
                    $bidRequest->status = BidRequest::STATUS_MATCHED;
                }

                $bidRequest->save();

                $bidRequests []= $bidRequest;
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        $bidData = fractal($bidRequests, new BidRequestTransformer())->toArray()['data'];

        $this->updateData();

        return response()->json([
            'success' => true,
            'message' => __('market.bid_success'),
            'bid' => $bidData
        ]);
    }

    public function destroy(BidRequest $bidRequest)
    {
        $this->authorize('delete', $bidRequest);

        DB::beginTransaction();
        try {
            $bidRequest = BidRequest::where('id', $bidRequest->id)->lockForUpdate()->first();

            if ($bidRequest->quantity_matched == 0) {
                $bidRequest->status = BidRequest::STATUS_CANCELLED;
            } else {
                $bidRequest->status = BidRequest::STATUS_MATCHED;
                $bidRequest->quantity = $bidRequest->quantity_matched;
                $bidRequest->quantity_pending = 0;
            }
            $bidRequest->save();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        $this->updateData();

        return response()->json([
            'success' => true,
            'message' => trans('market.delete_success')
        ]);
    }

    protected function updateData()
    {
        Cache::forget('market');
        broadcast(new MarketDataUpdated(['success' => true, 'time' => (new Carbon())->timestamp]))->toOthers();
    }
}
