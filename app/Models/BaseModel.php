<?php

namespace App;

//use App\Traits\EloquentGetTableNameTrait;
//use LiamWiltshire\LaravelJitLoader\Concerns\AutoloadsRelationships;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
//    use EloquentGetTableNameTrait, AutoloadsRelationships;

    public function scopeWithoutTimestamps()
    {
        $this->timestamps = false;
        return $this;
    }
}
