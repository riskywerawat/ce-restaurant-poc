<?php

namespace App\Http\Controllers\Dashboard;

use App\Actions\Dashboard\TransactionFilterAction;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(TransactionFilterAction $transactionFilterAction)
    {
        $this->authorize('viewAny', Transaction::class);

        $transactions = $transactionFilterAction->execute();

        return view('dashboard.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $this->authorize('view', $transaction);

        return view('dashboard.transactions.show', compact('transaction'));
    }


//    public function destroy(Transaction $transaction)
//    {
//        $this->authorize('delete', $transaction);
//
//        $transaction->delete();
//
//        return redirect()->route('dashboard.transactions.index')->with('success', 'ลบรายการเรียบร้อย');
//    }
}
