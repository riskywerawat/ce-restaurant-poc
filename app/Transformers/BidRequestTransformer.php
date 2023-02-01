<?php

namespace App\Transformers;

use App\Models\BidRequest;
use League\Fractal\TransformerAbstract;

class BidRequestTransformer extends TransformerAbstract
{
    /** @var bool */
    protected $history;
    protected $alternateDate;
    protected $alternate;

    public function __construct($history = false)
    {
        $this->history = $history;
        $this->alternateDate = null;
        $this->alternate = false;
    }

    /**
     * A Fractal transformer.
     *
     * @param BidRequest $bidRequest
     * @return array
     * @throws \App\Exceptions\PresenterException
     */
    public function transform($bidRequest)
    {
        if ($bidRequest->delivery_date->format('d-m-Y') == $this->alternateDate) {
            // OK
        } else {
            $this->alternate = !$this->alternate;
            $this->alternateDate = $bidRequest->delivery_date->format('d-m-Y');
        }

        $data = [
            'id' => $bidRequest->id,
            'user_id' => $bidRequest->user_id,
//            'status' => $bidRequest->status,
//            'quantity' => $bidRequest->quantity,
//            'quantity_matched' => $bidRequest->quantity_matched,
            'delivery_date' => $bidRequest->delivery_date->format('d-m-Y'),
            'delivery_date_timestamp' => $bidRequest->delivery_date->timestamp,
            'quantity' => (int) $bidRequest->quantity_pending,
            'price' => (float) $bidRequest->present()->price, // Baht
            'fee' => (float) $bidRequest->present()->fee, // Percent
            'created_at' => $bidRequest->created_at->timestamp,
            'alternate' => $this->alternate
        ];

        if ($this->history) {
            $data['quantity'] = $bidRequest->quantity;
            $data['quantity_matched'] = $bidRequest->quantity_matched;
            $data['total'] = $bidRequest->present()->totalWithFee; // from qty x price
            $data['status'] = $bidRequest->status;
            $data['transactions'] = fractal($bidRequest->transactions, new BidTransactionTransformer())
                ->toArray()['data'];

            $quantityLeft = $bidRequest->quantity;
            $realTotal = 0; // Baht
            $realTotalWithFee = 0; // Baht
            foreach($bidRequest->transactions as $transaction) {
                $quantityLeft -= $transaction->quantity;
                $realTotal += $transaction->present()->total;
                $realTotalWithFee += $transaction->present()->buyerSpend;
            }
            if ($quantityLeft > 0) {
                $toAdd = $quantityLeft * $bidRequest->present()->price; // Baht
                $toAddWithFee = $toAdd * (100+$bidRequest->fee) / 100;

                $realTotal += $toAdd;
                $realTotalWithFee += $toAddWithFee;
            }
            $data['total_real'] = $realTotal;
            $data['total_real_with_fee'] = $realTotalWithFee;

        }

        return $data;
    }
}
