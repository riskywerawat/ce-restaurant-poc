<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy extends BasePolicy
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
    public function view(User $user, Transaction $transaction)
    {
        return $this->isOwner($user, $transaction);
    }

    /**
     * Determine whether the user can create transactions.
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the transaction.
     *
     * @return mixed
     */
    public function update(/*User $user, Transaction $transaction*/)
    {
        return false;
    }

    /**
     * Determine whether the user can cancel the transaction.
     *
     * @return mixed
     */
    public function delete(User $user, Transaction $transaction)
    {
        return $this->isOwner($user, $transaction);
    }

    /**
     * Determine whether the user can restore the transaction.
     *
     * @return mixed
     */
    public function restore(/*User $user, Transaction $transaction*/)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the transaction.
     *
     * @return mixed
     */
    public function forceDelete(/*User $user, Transaction $transaction*/)
    {
        return false;
    }
}
