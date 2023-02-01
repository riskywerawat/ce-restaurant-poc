<?php

namespace App\Models;

use App\Traits\Presentable;
use App\Traits\RequestSortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Want to buy
class BidRequest extends Model
{
    use HasFactory, Presentable, RequestSortable;

    protected $presenter = \App\Presenters\BidRequestPresenter::class;

    protected $casts = [
        'delivery_date' => 'date',
    ];

    public const STATUS_ACTIVE = 1; // active or partial matched
    public const STATUS_MATCHED = 2; // fully matched
    public const STATUS_CANCELLED = 10; // cancelled without any matched
    public const STATUS_EXPIRED = 11; // expired (pass delivery date - 2)

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', BidRequest::STATUS_ACTIVE);
    }

    public function scopeMatched($query)
    {
        return $query->where('status', BidRequest::STATUS_MATCHED);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('delivery_date')->orderByDesc('price')->orderBy('created_at');
    }

    public function dashboardUrl()
    {
        return route('dashboard.bid_requests.show', $this->id);
    }
}
