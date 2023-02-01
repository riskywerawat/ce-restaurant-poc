<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function manage(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view any users.
     *
     * @return mixed
     */
    public function viewAny(/*User $user*/)
    {
        return true;
    }

    /**
     * Determine whether the user can view the user.
     *
     * @return mixed
     */
    public function view(/*User $user, User $userObject*/)
    {
        return true;
    }

    /**
     * Determine whether the user can create users.
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin(); // for admin only
    }

    /**
     * Determine whether the user can update the user.
     *
     * @return mixed
     */
    public function update(User $user, User $userObject)
    {
        return $user->id == $userObject->id;
    }

    public function updateRole(User $user, User $userObject)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @return mixed
     */
    public function delete(User $user, User $userObject)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the user.
     *
     * @return mixed
     */
    public function restore(/*User $user, User $userObject*/)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the user.
     *
     * @return mixed
     */
    public function forceDelete(/*User $user, User $userObject*/)
    {
        return false;
    }
}
