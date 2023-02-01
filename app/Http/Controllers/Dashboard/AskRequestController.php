<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AskRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AskRequestController extends Controller
{
    public function show(AskRequest $askRequest)
    {
        $this->authorize('view', $askRequest);

        $transactions = $askRequest->transactions;

        return view('dashboard.ask_requests.show', compact('askRequest', 'transactions'));
    }

}
