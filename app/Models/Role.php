<?php

namespace App\Models;

use App\Traits\Presentable;
use Spatie\Permission\Models\Role as Model;

class Role extends Model
{
    use Presentable;

    protected $presenter = \App\Presenters\RolePresenter::class;

    // Not real model, just for enum store
    public const SUPER_ADMIN = 'super_admin';
    public const ADMIN = 'admin';
//    public const BUYER = 'buyer'; // use enum in user table instead
//    public const SELLER = 'seller';
}
