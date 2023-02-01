<?php

namespace App\Transformers;

use App\Models\Transaction;
use League\Fractal\TransformerAbstract;

class BidTransactionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @param Transaction $transaction
     * @return array
     * @throws \App\Exceptions\PresenterException
     */
    public function transform($transaction)
    {
        return [
            'id' => $transaction->id,
//            'delivery_date' => $bidRequest->delivery_date->format('Y-m-d'),
            'quantity' => (int) $transaction->quantity,
            'price' => (int) $transaction->present()->price, // Baht
            'total' => $transaction->present()->buyerSpend, // with fee
            'created_at' => $transaction->present()->createdAt
        ];
    }
}
