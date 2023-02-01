<?php

namespace App\Policies;

use App\Models\User;

class BasePolicy
{
    public function before(User $user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
//        if ($ability == 'view' || $ability == 'viewAny' || $ability == 'viewPrivate') {
//            if ($user->isAdminReadOnly()) {
//                return true;
//            }
//        }
    }
}
