<?php

namespace App\Presenters;

use App\Models\Role;
use App\Models\User;

class UserPresenter extends BasePresenter
{
    /**
     * @var \App\Models\User
     */
    protected $model;

//    public function thumbnail()
//    {
//        if ($this->model->getMedia(User::MEDIA_COLLECTION_PHOTO)->count() > 0) {
//            return $this->model->getFirstMediaUrl(User::MEDIA_COLLECTION_PHOTO, 'thumbnail');
//        }
//        return asset('images/user.svg');
//    }
//
//    public function photo()
//    {
//        if ($this->model->getMedia(User::MEDIA_COLLECTION_PHOTO)->count() > 0) {
//            return $this->model->getFirstMediaUrl(User::MEDIA_COLLECTION_PHOTO, 'optimized');
//        }
//        return asset('images/user.svg');
//    }

    public function roleText()
    {
        if ($this->model->type) {
            if ($this->model->type == User::TYPE_BUYER) {
                return trans('dashboard/user.form.buyer');
            }
            if ($this->model->type == User::TYPE_SELLER) {
                return trans('dashboard/user.form.seller');
            }
        }

        $roles = $this->model->roles;
        if (count($roles) > 0) {
            return implode(', ', $roles->pluck('name')->map(function ($item) {
                return ucfirst(snakeCaseToText($item));
            })->all());
        }

        return 'ผู้ใช้ทั่วไป';
    }

    public function roleBadge()
    {
        $roles = $this->model->roles;

        if (count($roles) > 0) {
            return implode(' ', $roles->pluck('name')->map(function ($role) {
                return $this->badge($role);
            })->all());
        }

        $type = 'seller';
        if ($this->model->type == User::TYPE_BUYER) {
            $type = 'buyer';
        }
        return $this->badge($type);
    }

    public function badge($role)
    {
        $prefix = 'dashboard.users._partials.';
        switch ($role) {
            case Role::SUPER_ADMIN:
                return view($prefix.'super_admin')->toHtml();
            case Role::ADMIN:
                return view($prefix.'admin')->toHtml();
            case 'seller':
                return view($prefix.'seller')->toHtml();
            case 'buyer':
                return view($prefix.'buyer')->toHtml();
            default:
            return null;
        }
    }
}
