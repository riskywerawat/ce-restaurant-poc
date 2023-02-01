<?php

namespace App\Models;

use App\Notifications\NewAskMatchNotification;
use App\Notifications\NewBidMatchNotification;
use App\Traits\Presentable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, Presentable;

    protected $presenter = \App\Presenters\TransactionPresenter::class;

    protected $casts = [
        'delivery_date' => 'date',
    ];

    protected static function booted()
    {
        static::created(function ($transaction) {
            $bidUser = $transaction->bidRequest->user;
            $bidUser->notify(new NewBidMatchNotification($transaction));

            $askUser = $transaction->askRequest->user;
            $askUser->notify(new NewAskMatchNotification($transaction));
        });
    }

    public function bidRequest()
    {
        return $this->belongsTo(BidRequest::class);
    }
    public function askRequest()
    {
        return $this->belongsTo(AskRequest::class);
    }

    public function dashboardUrl()
    {
        return route('dashboard.transactions.show', $this->id);
    }
}
