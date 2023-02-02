<?php

namespace App\Models;

use App\Traits\Presentable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class OrderRequest extends Model
{
    use HasApiTokens;
    use HasFactory;


    use HasRoles, Presentable;
    protected $presenter = \App\Presenters\RolePresenter::class;
    public function kitchen()
    {
        return $this->belongsTo(Kitchen::class);
    }

    public function dashboardUrl()
    {
        return route('dashboard.order_request.show', $this->id);
    }

    public function getDiffMinute($time)
    {
        $timeNow = Carbon::now();
        $diff_in_minutes = $timeNow->diffInMinutes($time);
        error_log($timeNow);
        error_log($time);
        error_log($diff_in_minutes);
        return $diff_in_minutes;
    }
}
