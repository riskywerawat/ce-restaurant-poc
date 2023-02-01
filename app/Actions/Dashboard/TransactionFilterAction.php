<?php

namespace App\Actions\Dashboard;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Builder;
use \DB;

class TransactionFilterAction
{
    public function execute()
    {
        $transactionsQuery = Transaction::query();

        $transactionCatIds = null;

        $paginate = request('per_page', 50);

        $search = request('search');

        $transaction = null;

        if ($search) {
            $transactionsQuery = $transactionsQuery->where('id', $search);
        }

        if (request()->filled('price_min') || request()->filled('price_max')) {
            if (request()->filled('price_min') && request()->filled('price_max')) {
                $transactionsQuery = $transactionsQuery->whereBetween('price', [request('price_min')*100, request('price_max')*100]);
            } elseif (request()->filled('price_min')) {
                $transactionsQuery = $transactionsQuery->where('price', '>=', request('price_min')*100);
            } elseif (request()->filled('price_max')) {
                $transactionsQuery = $transactionsQuery->where('price', '<=', request('price_max')*100);
            }
        }

        if (request()->filled('quantity_min') || request()->filled('quantity_max')) {
            if (request()->filled('quantity_min') && request()->filled('quantity_max')) {
                $transactionsQuery = $transactionsQuery->whereBetween('quantity', [request('quantity_min'), request('quantity_max')]);
            } elseif (request()->filled('quantity_min')) {
                $transactionsQuery = $transactionsQuery->where('quantity', '>=', request('quantity_min'));
            } elseif (request()->filled('quantity_max')) {
                $transactionsQuery = $transactionsQuery->where('quantity', '<=', request('quantity_max'));
            }
        }

        if (request()->filled('delivery_start') || request()->filled('delivery_end')) {
            if (request()->filled('delivery_start') && request()->filled('delivery_end')) {
                $transactionsQuery = $transactionsQuery->whereBetween('delivery_date', [request('delivery_start'), request('delivery_end')]);
            } elseif (request()->filled('delivery_start')) {
                $transactionsQuery = $transactionsQuery->where('delivery_date', '>=', request('delivery_start'));
            } elseif (request()->filled('delivery_end')) {
                $transactionsQuery = $transactionsQuery->where('delivery_date', '<=', request('delivery_end'));
            }
        }

        switch (request('order_by')) {
            case 'delivery':
                $orderBy = 'delivery_date';
                break;
            case 'price':
                $orderBy = 'price';
                break;
            case 'quantity':
                $orderBy = 'quantity';
                break;
            case 'id':
                $orderBy = 'id';
                break;
            default:
                $orderBy = 'created_at';
        }

        $order = 'desc';
        if (request('order') == 'asc') {
            $order = 'asc';
        }

        $transactions = $transactionsQuery
            ->with(['askRequest.user', 'bidRequest.user'])
            ->orderBy($orderBy, $order)
            ->paginate($paginate);

        return $transactions;
    }

    protected function addQuerySlashes($string)
    {
        // need 3 slashes for json field (eg: 18" eighteen eleven must search with 18\\\" eighteen eleven
        return str_replace('"', '\\\\\\"', $string);
    }
}
