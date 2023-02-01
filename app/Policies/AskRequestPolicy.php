<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AskRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class AskRequestPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
        if ($ability == 'view' || $ability == 'viewAny' || $ability == 'viewPrivate') {
            if ($user->isAdmin()) {
                return true;
            }
        }
    }

    protected function isOwner(User $user, AskRequest $askRequest)
    {
        return $user->id === $askRequest->user_id;
    }

    public function manage(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view any users.
     *
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the ask request.
     *
     * @return mixed
     */
    public function view(User $user, AskRequest $askRequest)
    {
        return $this->isOwner($user, $askRequest);
    }

    /**
     * Determine whether the user can create ask requests.
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isSeller();
    }

    /**
     * Determine whether the user can update the ask request.
     *
     * @return mixed
     */
    public function update(/*User $user, AskRequest $askRequest*/)
    {
        return false;
    }

    /**
     * Determine whether the user can cancel the ask request.
     *
     * @return mixed
     */
    public function delete(User $user, AskRequest $askRequest)
    {
        return $this->isOwner($user, $askRequest);
    }

    /**
     * Determine whether the user can restore the ask request.
     *
     * @return mixed
     */
    public function restore(/*User $user, AskRequest $askRequest*/)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the ask request.
     *
     * @return mixed
     */
    public function forceDelete(/*User $user, AskRequest $askRequest*/)
    {
        return false;
    }
}
