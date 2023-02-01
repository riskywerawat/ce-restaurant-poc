<?php

namespace App\Policies;

use App\Models\User;
use App\Models\BidRequest;
use Illuminate\Auth\Access\HandlesAuthorization;

class BidRequestPolicy extends BasePolicy
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

    protected function isOwner(User $user, BidRequest $bidRequest)
    {
        return $user->id === $bidRequest->user_id;
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
     * Determine whether the user can view the bid request.
     *
     * @return mixed
     */
    public function view(User $user, BidRequest $bidRequest)
    {
        return $this->isOwner($user, $bidRequest);
    }

    /**
     * Determine whether the user can create bid requests.
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isBuyer();
    }

    /**
     * Determine whether the user can update the bid request.
     *
     * @return mixed
     */
    public function update(/*User $user, BidRequest $bidRequest*/)
    {
        return false;
    }

    /**
     * Determine whether the user can cancel the bid request.
     *
     * @return mixed
     */
    public function delete(User $user, BidRequest $bidRequest)
    {
        return $this->isOwner($user, $bidRequest);
    }

    /**
     * Determine whether the user can restore the bid request.
     *
     * @return mixed
     */
    public function restore(/*User $user, BidRequest $bidRequest*/)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the bid request.
     *
     * @return mixed
     */
    public function forceDelete(/*User $user, BidRequest $bidRequest*/)
    {
        return false;
    }
}
