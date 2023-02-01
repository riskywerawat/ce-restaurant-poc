<?php

namespace App\Http\Controllers;

use App\Models\AskRequest;
use App\Models\BidRequest;
use App\Models\Transaction;
use App\Transformers\AskRequestTransformer;
use App\Transformers\BidRequestTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MarketController extends Controller
{
    public function index(Request $request)
    {
        $fiveMinutes = 300; // in seconds
        $marketData = Cache::remember('market', $fiveMinutes, function () {
            $bidsRaw = BidRequest::active()->ordered()->get();
            $asksRaw = AskRequest::active()->ordered()->get();
            return [
                'bids' => fractal($bidsRaw, new BidRequestTransformer())->toArray()['data'],
                'asks' =>fractal($asksRaw, new AskRequestTransformer())->toArray()['data']
            ];
        });

//        $bids = BidRequest::active()->ordered()->get();
//        $bidsData = fractal($bids, new BidRequestTransformer())->toArray()['data'];
        $bidsData = $marketData['bids'];
//        return $bidsData;

//        $asks = AskRequest::active()->ordered()->get();
//        $asksData = fractal($asks, new AskRequestTransformer())->toArray()['data'];
        $asksData = $marketData['asks'];

        $user = $request->user();
        $myBidsData = [];
        $myAsksData = [];
        if ($user->isBuyer()) {
            $myBids = BidRequest::where('user_id', $user->id)->active()->ordered()->get();
            $myBidsData = fractal($myBids, new BidRequestTransformer())->toArray()['data'];
        }
        if ($user->isSeller()) {
            $myAsks = AskRequest::where('user_id', $user->id)->active()->ordered()->get();
            $myAsksData = fractal($myAsks, new AskRequestTransformer())->toArray()['data'];
        }

        if (request()->expectsJson()) {
            return response()->json([
                'asks' => $asksData,
                'bids' => $bidsData,
                'myAsks' => $myAsksData,
                'myBids' => $myBidsData,
            ]);
        }

        $startDate = (new Carbon('Asia/Bangkok'))->addDays(config('rms.start_days'));
        $endDate = (new Carbon('Asia/Bangkok'))->addMonth();

        $graphData = $this->graphData($startDate->format('Ymd'), $endDate->format('Ymd'));
//        $label = $graphData['label'];
//        $data = $graphData['data'];

//        dd($graphData);
        $graphDataFilled = $this->fillGraphData($graphData);
//        dd($graphDataFilled);

        return view('public.market', compact(
            'bidsData', 'asksData',
            'myAsksData', 'myBidsData',
            // 'label', 'data', // graph
            'graphData', 'graphDataFilled',
            'startDate', 'endDate'
        ));
    }

    public function graph(Request $request)
    {
        $graphData = $this->graphData($request->start, $request->end);

        return response()->json([
            'success' => true,
//            'label' => $graphData['label'],
//            'data' => $graphData['data'],
            'data' => $graphData,
            'start' => $request->start,
            'end' => $request->end,
        ]);
    }

    public function graphData($start, $end)
    {
//        $label = [];
//        $highestBidData = [];
//        $lowestBidData = [];
//        $highestAskData = [];
//        $lowestAskData = [];
//        $highestMatchedData = [];
//        $lowestMatchedData = [];

        $data = [];

        $dateIterator = (Carbon::createFromFormat('Ymd', $start, 'Asia/Bangkok'))->startOfDay();
        $endDate = (Carbon::createFromFormat('Ymd', $end, 'Asia/Bangkok'))->startOfDay();

        $bidRequests = BidRequest::where('delivery_date', '>=', $dateIterator)
            ->where('delivery_date', '<=', $endDate)
            ->active()
            ->get();

        $askRequests = AskRequest::where('delivery_date', '>=', $dateIterator)
            ->where('delivery_date', '<=', $endDate)
            ->active()
            ->get();

        $transactions = Transaction::where('delivery_date', '>=', $dateIterator)
            ->where('delivery_date', '<=', $endDate)
            ->get();

        while ($dateIterator <= $endDate) {

//            $dateText = $dateIterator->format('Y-m-d');
//            $highestBidPrice = $bidRequests->filter(function ($value, $key) use($dateIterator) {
//                    return $value['delivery_date']->isSameDay($dateIterator);
//                })->max('price') ?? 0;
//            $highestBidPrice = $highestBidPrice !== null ? $highestBidPrice / 100 : null;

            $lowestBidPrice = $bidRequests->filter(function ($value, $key) use($dateIterator) {
                    return $value['delivery_date']->isSameDay($dateIterator);
                })->min('price') ?? null;
            $lowestBidPrice = $lowestBidPrice !== null ? $lowestBidPrice / 100 : null;

            $highestAskPrice = $askRequests->filter(function ($value, $key) use($dateIterator) {
                    return $value['delivery_date']->isSameDay($dateIterator);
                })->max('price') ?? null;
            $highestAskPrice = $highestAskPrice !== null ? $highestAskPrice / 100 : null;

//            $lowestAskPrice = $askRequests->filter(function ($value, $key) use($dateIterator) {
//                    return $value['delivery_date']->isSameDay($dateIterator);
//                })->min('price') ?? null;
//            $lowestAskPrice = $lowestAskPrice !== null ? $lowestAskPrice / 100 : null;

            $highestMatchedPrice = $transactions->filter(function ($value, $key) use($dateIterator) {
                    return $value['delivery_date']->isSameDay($dateIterator);
                })->max('price') ?? null;
            $highestMatchedPrice = $highestMatchedPrice !== null ? $highestMatchedPrice / 100 : null;

            $lowestMatchedPrice = $transactions->filter(function ($value, $key) use($dateIterator) {
                    return $value['delivery_date']->isSameDay($dateIterator);
                })->min('price') ?? null;
            $lowestMatchedPrice = $lowestMatchedPrice !== null ? $lowestMatchedPrice / 100 : null;

            $data []= [
                'x' => $dateIterator->format('j M Y'),
                // [open, highest, lowest, close]
                'y' => [$lowestMatchedPrice, $highestAskPrice, $lowestBidPrice, $highestMatchedPrice]
//                'y' => [$lowestMatchedPrice, $lowestBidPrice, $highestAskPrice, $highestMatchedPrice]
            ];

            $dateIterator->addDay();
        }

        return [
            [
                'data' => $data
            ]
        ];
    }

    public function fillGraphData($data)
    {
        $result = [];

        $rows = $data[0]['data'];

        foreach ($rows as $row) {
            $lowestMatchedPrice = $row['y'][0];
            $highestAskPrice = $row['y'][1];
            $lowestBidPrice = $row['y'][2];
            $highestMatchedPrice = $row['y'][3];

            if ($lowestBidPrice + $lowestMatchedPrice + $highestMatchedPrice + $highestAskPrice > 0) {
                if ($lowestBidPrice == null) {
                    $lowestBidPrice = $lowestMatchedPrice;
                }
                if ($lowestBidPrice == null) {
//                    $lowestBidPrice = $highestAskPrice;
                    $lowestBidPrice = $highestMatchedPrice;
                }
                if ($lowestBidPrice == null) {
                    $lowestBidPrice = $highestAskPrice;
                }

                if ($highestAskPrice == null) {
                    $highestAskPrice = $highestMatchedPrice;
                }
                if ($highestAskPrice == null) {
//                    $highestAskPrice = $lowestBidPrice;
                    $highestAskPrice = $lowestMatchedPrice;
                }
                if ($highestAskPrice == null) {
                    $highestAskPrice = $lowestBidPrice;
                }

                if ($lowestMatchedPrice == null) {
//                    $lowestMatchedPrice = $lowestBidPrice;
                    $lowestMatchedPrice = $highestMatchedPrice;
                }
                if ($lowestMatchedPrice == null) {
                    $lowestMatchedPrice = $lowestBidPrice;
                }
                if ($lowestMatchedPrice == null) {
                    $lowestMatchedPrice = $highestAskPrice;
                }

                if ($highestMatchedPrice == null) {
//                    $highestMatchedPrice = $highestAskPrice;
                    $highestMatchedPrice = $lowestMatchedPrice;
                }
                if ($highestMatchedPrice == null) {
                    $highestMatchedPrice = $lowestBidPrice;
                }
                if ($highestMatchedPrice == null) {
                    $highestMatchedPrice = $highestAskPrice;
                }
            }

            $result []= [
                'x' => $row['x'],
                // [open, highest, lowest, close]
                'y' => [$lowestMatchedPrice, $highestAskPrice, $lowestBidPrice, $highestMatchedPrice]
//                'y' => [$lowestBidPrice, $lowestMatchedPrice, $highestMatchedPrice, $highestAskPrice]
            ];
        }

//        return $result;
        return [
            [
                'data' => $result
            ]
        ];
    }

    public function graphDataOld($start, $end)
    {
//        $label = ['bbb', 1992, 1993, 1994, 1995, 1996, 1997, 1998];
//        $data = [
//            [
//                'name' => 'Highest Bid',
//                'data' => [30, 40, 45, 50, 49, 60, 70, 91]
//            ],
//            [
//                'name' => 'Lowest Bid',
//                'data' => [15, 20, 38, 66, 45, 55, 60, 56]
//            ],
//            [
//                'name' => 'Highest Ask',
//                'data' => [25, 50, 60, 45, 55, 80, 90, 84]
//            ],
//            [
//                'name' => 'Lowest Ask',
//                'data' => [22, 27, 36, 51, 42, 47, 62, 59]
//            ],
//            [
//                'name' => 'Highest Matched',
//                'data' => [20, 59, 75, 54, 66, 84, 98, 97]
//            ],
//            [
//                'name' => 'Lowest Matched',
//                'data' => [12, 22, 31, 54, 49, 41, 55, 38]
//            ],
//        ];
//
//        return [
//            'label' => $label,
//            'data' => $data
//        ];

        $label = [];
        $highestBidData = [];
        $lowestBidData = [];
        $highestAskData = [];
        $lowestAskData = [];
        $highestMatchedData = [];
        $lowestMatchedData = [];

        $dateIterator = (Carbon::createFromFormat('Ymd', $start, 'Asia/Bangkok'))->startOfDay();
        $endDate = (Carbon::createFromFormat('Ymd', $end, 'Asia/Bangkok'))->startOfDay();

        $bidRequests = BidRequest::where('delivery_date', '>=', $dateIterator)
            ->where('delivery_date', '<=', $endDate)
            ->get();

        $askRequests = AskRequest::where('delivery_date', '>=', $dateIterator)
            ->where('delivery_date', '<=', $endDate)
            ->get();

        $transactions = Transaction::where('delivery_date', '>=', $dateIterator)
            ->where('delivery_date', '<=', $endDate)
            ->get();

        while ($dateIterator <= $endDate) {

//            $bidRequests->where('delivery_date', $dateIterator->format('Y-m-d'))->max('price')
            $dateText = $dateIterator->format('Y-m-d');
            $highestBidPrice = $bidRequests->filter(function ($value, $key) use($dateIterator) {
                return $value['delivery_date']->isSameDay($dateIterator);
            })->max('price') ?? 0;
            $highestBidData []= $highestBidPrice / 100;

            $lowestBidPrice = $bidRequests->filter(function ($value, $key) use($dateIterator) {
                    return $value['delivery_date']->isSameDay($dateIterator);
                })->min('price') ?? 0;
            $lowestBidData []= $lowestBidPrice / 100;

            $highestAskPrice = $askRequests->filter(function ($value, $key) use($dateIterator) {
                    return $value['delivery_date']->isSameDay($dateIterator);
                })->max('price') ?? 0;
            $highestAskData []= $highestAskPrice / 100;

            $lowestAskPrice = $askRequests->filter(function ($value, $key) use($dateIterator) {
                    return $value['delivery_date']->isSameDay($dateIterator);
                })->min('price') ?? 0;
            $lowestAskData []= $lowestAskPrice / 100;

            $highestMatchedPrice = $transactions->filter(function ($value, $key) use($dateIterator) {
                    return $value['delivery_date']->isSameDay($dateIterator);
                })->max('price') ?? 0;
            $highestMatchedData []= $highestMatchedPrice / 100;

            $lowestMatchedPrice = $transactions->filter(function ($value, $key) use($dateIterator) {
                    return $value['delivery_date']->isSameDay($dateIterator);
                })->min('price') ?? 0;
            $lowestMatchedData []= $lowestMatchedPrice / 100;

            $label[] = $dateIterator->format('j M Y');

            $dateIterator->addDay();
        }

        $data = [
            [
                'name' => trans('market.graph_categories.highest_bid'),
                'data' => $highestBidData
            ],
            [
                'name' => trans('market.graph_categories.lowest_bid'),
                'data' => $lowestBidData
            ],
            [
                'name' => trans('market.graph_categories.highest_ask'),
                'data' => $highestAskData
            ],
            [
                'name' => trans('market.graph_categories.lowest_ask'),
                'data' => $lowestAskData
            ],
            [
                'name' => trans('market.graph_categories.highest_matched'),
                'data' => $highestMatchedData
            ],
            [
                'name' => trans('market.graph_categories.lowest_matched'),
                'data' => $lowestMatchedData
            ],
        ];

        return [
            'label' => $label,
            'data' => $data
        ];
    }

    public function test()
    {
        $graphData = $this->graphData('20201101', '20201130');

        $graphData[0]['data'][0]['y'] = [200, 100, 400, 300];
        $graphData[0]['data'][1]['y'] = [1000, 800, 1300, 1300];

        return view('test_graph', compact('graphData'));
    }
}
