<?php

namespace App\Http\Controllers;

use App\Events\MarketDataUpdated;
use App\Http\Requests\CreateBidRequest;
use App\Models\AskRequest;
use App\Models\BidRequest;
use App\Models\SiteSetting;
use App\Models\Transaction;
use App\Transformers\AskRequestTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AskRequestController extends Controller
{
    public function store(CreateBidRequest $request)
    {
        $this->authorize('create', AskRequest::class);

        $user = $request->user();

        $dates = $request->delivery_date;

        $priceSatang = $request->price * 100; // Baht to Satang
        $askRequests = [];
        $now = new Carbon();

        DB::beginTransaction();
        try {
            $bidsRequests = BidRequest::active()
                ->where('price', '>=' , $priceSatang)
                ->whereIn('delivery_date', $dates)
                ->lockForUpdate() // prevent other request from select same ask requests
                ->get();

            foreach ($dates as $date) {

                $bidRequestsSameDay = $bidsRequests->filter(function ($value, $key) use($date) {
                    return $value->delivery_date->format('Y-m-d') == $date;
                })->sort(function ($a, $b) {
                    if ($a->price === $b->price) { // if same price order by created at
                        return $a->created_at <=> $b->created_at;
                    }
                    return $b->price <=> $a->price;
                });

                // temporary create ask for each day
                $askRequest = new AskRequest();
                $askRequest->user_id = $user->id;
                $askRequest->status = AskRequest::STATUS_ACTIVE;
                $askRequest->delivery_date = $date;
                $askRequest->quantity = $request->quantity;
                $askRequest->quantity_matched = 0;
                $askRequest->quantity_pending = $request->quantity;
                $askRequest->price = $priceSatang;
                $askRequest->fee = SiteSetting::askFeePercent();
                $askRequest->created_at = $now;
                $askRequest->updated_at = $now;
                $askRequest->save();

                foreach ($bidRequestsSameDay as $bidRequest) {
                    if ($askRequest->quantity_pending <= 0) { // fully matched
                        break;
                    }

                    // found matched
                    $quantityMatched = min($askRequest->quantity_pending, $bidRequest->quantity_pending);
                    $priceMatchedSatang = max($priceSatang, $bidRequest->price);
                    $bidRequest->quantity_matched += $quantityMatched;
                    $bidRequest->quantity_pending -= $quantityMatched;
                    if ($bidRequest->quantity_pending == 0) {
                        $bidRequest->status = AskRequest::STATUS_MATCHED;
                    }
                    $bidRequest->save();

                    $askRequest->quantity_matched += $quantityMatched;
                    $askRequest->quantity_pending -= $quantityMatched;

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

                if ($askRequest->quantity_pending <= 0) {
                    $askRequest->status = AskRequest::STATUS_MATCHED;
                }

                $askRequest->save();

                $askRequests []= $askRequest;
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }

        $askData = fractal($askRequests, new AskRequestTransformer())->toArray()['data'];

        $this->updateData();

        return response()->json([
            'success' => true,
            'message' => __('market.ask_success'),
            'ask' => $askData
        ]);
    }

    public function destroy(AskRequest $askRequest)
    {
        $this->authorize('delete', $askRequest);

        DB::beginTransaction();
        try {
            $askRequest = AskRequest::where('id', $askRequest->id)->lockForUpdate()->first();

            if ($askRequest->quantity_matched == 0) {
                $askRequest->status = AskRequest::STATUS_CANCELLED;
            } else {
                $askRequest->status = AskRequest::STATUS_MATCHED;
                $askRequest->quantity = $askRequest->quantity_matched;
                $askRequest->quantity_pending = 0;
            }
            $askRequest->save();

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
