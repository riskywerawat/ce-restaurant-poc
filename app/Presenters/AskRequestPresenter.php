<?php

namespace App\Presenters;

use App\Models\AskRequest;

class AskRequestPresenter extends BasePresenter
{
    /**
     * @var \App\Models\AskRequest
     */
    protected $model;

    public function statusBadge()
    {
        $prefix = 'dashboard.bid_requests._partials.';
        $status = $this->model->status;
        switch ($status) {
            case AskRequest::STATUS_ACTIVE:
                return view($prefix.'active')->toHtml();
            case AskRequest::STATUS_MATCHED:
                return view($prefix.'matched')->toHtml();
            case AskRequest::STATUS_CANCELLED:
                return view($prefix.'cancelled')->toHtml();
            case AskRequest::STATUS_EXPIRED:
                return view($prefix.'expired')->toHtml();
            default:
                return null;
        }
    }

    public function price()
    {
        return $this->model->price / 100; // Satang to Baht
    }
    public function total()
    {
        return $this->price() * $this->model->quantity;
    }
    public function totalWithFee() // what seller gain
    {
        return $this->total() * $this->feeMultiplyer();
    }

    public function totalMatched()
    {
        return $this->price() * $this->model->quantity_matched;
    }
    public function totalMatchedWithFee() // what seller gain
    {
        return $this->totalMatched() * $this->feeMultiplyer();
    }
    public function totalPending()
    {
        return $this->price() * $this->model->quantity_pending;
    }
    public function totalPendingWithFee()
    {
        return $this->totalPending() * $this->feeMultiplyer();
    }

    public function deliveryDate()
    {
        return $this->model->delivery_date->format('d-m-Y');
    }

    protected function feeMultiplyer()
    {
        return (100-$this->model->fee) / 100;
    }
}
