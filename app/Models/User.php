<?php

namespace App\Models;

use App\Notifications\ResetPinNotification;
use App\Traits\Presentable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles, Presentable;

    protected $presenter = \App\Presenters\UserPresenter::class;

    public const TYPE_BUYER = 1;
    public const TYPE_SELLER = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function bidRequests()
    {
        return $this->hasMany(BidRequest::class);
    }

    public function askRequests()
    {
        return $this->hasMany(AskRequest::class);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole([Role::ADMIN, Role::SUPER_ADMIN]);
    }

    public function isSuperAdmin(): bool
    {
        return $this->hasRole([Role::SUPER_ADMIN]);
    }

    public function isUser(): bool
    {
        return in_array($this->type, [User::TYPE_BUYER, User::TYPE_SELLER]) && count($this->roles) == 0;
    }

    public function isBuyer(): bool
    {
        return $this->type === User::TYPE_BUYER && count($this->roles) == 0;
    }

    public function isSeller(): bool
    {
        return $this->type === User::TYPE_SELLER && count($this->roles) == 0;
    }

//    public function sendPinResetNotification($token)
//    {
//        $this->notify(new ResetPinNotification($token));
//    }

    public function canAccessDashboard(): bool
    {
        return $this->hasRole([Role::ADMIN, Role::SUPER_ADMIN]);
    }

    public function dashboardUrl()
    {
        return route('dashboard.users.show', $this->id);
    }

    public function dashboardUrlEdit()
    {
        return route('dashboard.users.edit', $this->id);
    }
}
