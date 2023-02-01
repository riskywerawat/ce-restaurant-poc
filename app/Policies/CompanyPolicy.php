<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Company;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function manage(User $user)
    {
        return $user->isAdminManager();
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
     * Determine whether the user can view the company.
     *
     * @return mixed
     */
    public function view(/*User $user, Company $company*/)
    {
        return true;
    }

    /**
     * Determine whether the user can create companies.
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdminManager(); // for admin only
    }

    /**
     * Determine whether the user can update the company.
     *
     * @return mixed
     */
    public function update(User $user, Company $company)
    {
        return $user->isAdminManager();
    }

    /**
     * Determine whether the user can delete the company.
     *
     * @return mixed
     */
    public function delete(User $user, Company $company)
    {
        return $user->isAdminManager();
    }

    /**
     * Determine whether the user can restore the company.
     *
     * @return mixed
     */
    public function restore(/*User $user, Company $company*/)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the company.
     *
     * @return mixed
     */
    public function forceDelete(/*User $user, Company $company*/)
    {
        return false;
    }
}
