<?php

namespace App\Presenters;

use App\Models\Role;

class RolePresenter extends BasePresenter
{
    /**
     * @var \App\Models\Role
     */
    protected $model;

    public function description()
    {
        switch ($this->model->name) {
            case Role::SUPER_ADMIN:
                return trans('dashboard/user.form.super_admin_description');
            case Role::ADMIN:
                return trans('dashboard/user.form.admin_description');
            default:
                return '...';
        }
    }
}
