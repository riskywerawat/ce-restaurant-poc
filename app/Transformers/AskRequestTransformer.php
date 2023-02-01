<?php

namespace App\Transformers;

use App\Models\AskRequest;
use League\Fractal\TransformerAbstract;

class AskRequestTransformer extends TransformerAbstract
{
    /** @var bool */
    protected $withTransactions;
    protected $alternateDate;
    protected $alternate;

    public function __construct($withTransactions = false)
    {
        $this->withTransactions = $withTransactions;
        $this->alternateDate = null;
        $this->alternate = false;
    }

    /**
     * A Fractal transformer.
     *
     * @param AskRequest $askRequest
     * @return array
     * @throws \App\Exceptions\PresenterException
     */
    public function transform($askRequest)
    {
        if ($askRequest->delivery_date->format('d-m-Y') == $this->alternateDate) {
            // OK
        } else {
            $this->alternate = !$this->alternate;
            $this->alternateDate = $askRequest->delivery_date->format('d-m-Y');
        }

        $data = [
            'id' => $askRequest->id,
            'user_id' => $askRequest->user_id,
//            'status' => $askRequest->status,
//            'quantity' => $askRequest->quantity,
//            'quantity_matched' => $askRequest->quantity_matched,
            'delivery_date' => $askRequest->delivery_date->format('d-m-Y'),
            'delivery_date_timestamp' => $askRequest->delivery_date->timestamp,
            'quantity' => (int) $askRequest->quantity_pending,
            'price' => (float) $askRequest->present()->price, // Baht
            'fee' => (float) $askRequest->present()->fee, // Percent
            'created_at' => $askRequest->created_at->timestamp,
            'alternate' => $this->alternate
        ];

        if ($this->withTransactions) {
            $data['quantity'] = $askRequest->quantity;
            $data['quantity_matched'] = $askRequest->quantity_matched;
            $data['total'] = $askRequest->present()->totalWithFee;
            $data['status'] = $askRequest->status;
            $data['transactions'] = fractal($askRequest->transactions, new AskTransactionTransformer())
                ->toArray()['data'];

            $quantityLeft = $askRequest->quantity;
            $realTotal = 0; // Baht
            $realTotalWithFee = 0; // Baht
            foreach($askRequest->transactions as $transaction) {
                $quantityLeft -= $transaction->quantity;
                $realTotal += $transaction->present()->total;
                $realTotalWithFee += $transaction->present()->sellerReceived;
            }
            if ($quantityLeft > 0) {
                $toAdd = $quantityLeft * $askRequest->present()->price; // Baht
                $toAddWithFee = $toAdd * (100-$askRequest->fee) / 100;

                $realTotal += $toAdd;
                $realTotalWithFee += $toAddWithFee;
            }
            $data['total_real'] = $realTotal;
            $data['total_real_with_fee'] = $realTotalWithFee;
        }

        return $data;
    }
}
