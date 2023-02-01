<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kitchen extends Model
{
    use HasFactory;

    public function OrderRequest()
    {
        return $this->hasMany(OrderRequest::class);
    }
}
