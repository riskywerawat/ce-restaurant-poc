<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SiteSetting;
use Illuminate\Auth\Access\HandlesAuthorization;

class SiteSettingPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function manage(User $user)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view any site settings.
     *
     * @return mixed
     */
    public function viewAny(/*User $user*/)
    {
        return true;
    }

    /**
     * Determine whether the user can view the site setting.
     *
     * @return mixed
     */
    public function view(User $user, SiteSetting $siteSetting)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create site settings.
     *
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isAdmin(); // for admin only
    }

    /**
     * Determine whether the user can update the site setting.
     *
     * @return mixed
     */
    public function update(User $user, SiteSetting $siteSetting)
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can delete the site setting.
     *
     * @return mixed
     */
    public function delete(/*User $user, SiteSetting $siteSetting*/)
    {
        return false;
    }

    /**
     * Determine whether the user can restore the site setting.
     *
     * @return mixed
     */
    public function restore(/*User $user, SiteSetting $siteSetting*/)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the site setting.
     *
     * @return mixed
     */
    public function forceDelete(/*User $user, SiteSetting $siteSetting*/)
    {
        return false;
    }
}
