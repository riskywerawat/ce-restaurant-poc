<?php

namespace App\Traits;

trait RequestSortable
{
    public function scopeOrdered($query)
    {
        return $query->orderBy('delivery_date'); //->orderByDesc('updated_at');
    }
}
