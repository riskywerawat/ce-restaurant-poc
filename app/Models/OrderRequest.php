<?php

namespace App\Models;

use App\Traits\Presentable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderRequest extends Model
{
    use HasFactory,Presentable;
    protected $presenter = \App\Presenters\RolePresenter::class;
    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }
    public function scopeActive($query)
    {
        return $query->where('status', AskRequest::STATUS_ACTIVE);
    }
    public function dashboardUrl()
    {
        return route('dashboard.order_request.show', 1);
    }
    public function dashboardUrlEdit()
    {
        return route('dashboard.users.edit', 1);
    }
}
