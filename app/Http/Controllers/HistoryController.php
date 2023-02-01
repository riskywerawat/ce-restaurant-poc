<?php

namespace App\Http\Controllers;

use App\Models\AskRequest;
use App\Models\BidRequest;
use App\Transformers\AskRequestTransformer;
use App\Transformers\BidRequestTransformer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($request->start) {
            $startDate = (Carbon::createFromFormat('Y-m-d', $request->start, 'Asia/Bangkok'));
        } else {
            $startDate = (new Carbon('Asia/Bangkok'))->addDays(config('rms.start_days'));
        }

        if ($request->end) {
            $endDate = (Carbon::createFromFormat('Y-m-d', $request->end, 'Asia/Bangkok'));
        } else {
            $endDate = (new Carbon('Asia/Bangkok'))->addMonth();
        }

        if ($user->isBuyer()) {
            $requests = BidRequest::with('transactions')
                ->where('user_id', $user->id)
                ->where('delivery_date', '>=', $startDate->format('Y-m-d'))
                ->where('delivery_date', '<=', $endDate->format('Y-m-d'))
                ->orderBy('delivery_date')
                ->orderBy('created_at')
                ->get();

            $requests = fractal($requests, new BidRequestTransformer(true))->toArray()['data'];
        } elseif ($user->isSeller()) {
            $requests = AskRequest::with('transactions')
                ->where('user_id', $user->id)
                ->where('delivery_date', '>=', $startDate->format('Y-m-d'))
                ->where('delivery_date', '<=', $endDate->format('Y-m-d'))
                ->orderBy('delivery_date')
                ->orderBy('created_at')
                ->get();

            $requests = fractal($requests, new AskRequestTransformer(true))->toArray()['data'];
        } else {
            abort(403);
        }

        if (request()->expectsJson()) {
            return response()->json([
                'requests' => $requests,
                'start' => $startDate->format('Y-m-d'),
                'end' => $endDate->format('Y-m-d')
            ]);
        }

        $mode = 'all';
        if ($request->mode) {
            $mode = $request->mode;
        }

        return view('public.history', compact('requests', 'startDate', 'endDate', 'mode'));
    }
}
