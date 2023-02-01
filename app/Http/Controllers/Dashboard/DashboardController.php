<?php

namespace App\Http\Controllers\Dashboard;

//use App\Http\Controllers\Controller;
use App\Models\AskRequest;
use App\Models\BidRequest;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class DashboardController extends AuthenticatedSessionController
{
//    use AuthenticatesUsers;

//    public $redirectTo = '/dashboard';

    public function login(Request $request)
    {
        return view('dashboard.login');
    }

    public function index()
    {
        $transactions = Transaction::orderByDesc('created_at')->take(10)->get();

        $now = new Carbon();
        $last30Days = (new Carbon())->subDays(30);
        $bidRequestsCount = BidRequest::where('created_at', '<=', $now)
            ->where('created_at', '>=', $last30Days)
            ->count();
        $askRequestsCount = AskRequest::where('created_at', '<=', $now)
            ->where('created_at', '>=', $last30Days)
            ->count();
        $transactionsCount = Transaction::where('created_at', '<=', $now)
            ->where('created_at', '>=', $last30Days)
            ->count();

        return view('dashboard.index', compact('transactions', 'bidRequestsCount', 'askRequestsCount', 'transactionsCount'));
    }

    public function logout(Request $request)
    {
        $this->guard->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return $request->wantsJson()
            ? new JsonResponse('', 204)
            : redirect()->route('dashboard.login');
    }
}
