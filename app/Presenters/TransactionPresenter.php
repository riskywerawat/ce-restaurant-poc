<?php

namespace App\Presenters;

use App\Models\Transaction;

class TransactionPresenter extends BasePresenter
{
    /**
     * @var \App\Models\Transaction
     */
    protected $model;

    public function price()
    {
        return $this->model->price / 100; // Satang to Baht
    }
    public function total()
    {
        return $this->price() * $this->model->quantity;
    }
    public function buyerSpend() // what buyer pay
    {
        return $this->total() * (100+$this->model->bid_fee) / 100;
    }
    public function buyerFee()
    {
        return $this->total() * ($this->model->bid_fee) / 100;
    }

    public function sellerReceived() // what seller received
    {
        return $this->total() * (100-$this->model->ask_fee) / 100;
    }
    public function sellerFee()
    {
        return $this->total() * ($this->model->ask_fee) / 100;
    }

    public function deliveryDate()
    {
        return $this->model->delivery_date->format('d-m-Y');
    }

    public function buyer()
    {
        return $this->model->bidRequest->user->present()->name;
    }

    public function seller()
    {
        return $this->model->askRequest->user->present()->name;
    }
}
