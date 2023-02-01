<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\BidRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BidRequestController extends Controller
{
    public function show(BidRequest $bidRequest)
    {
        $this->authorize('view', $bidRequest);

        $transactions = $bidRequest->transactions;

        return view('dashboard.bid_requests.show', compact('bidRequest', 'transactions'));
    }

}
