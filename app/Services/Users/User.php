<?php

namespace App\Services\Users;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\UserResetPassword;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Class User
 * @package App\Services\Users
 * @author Bryan James Dela Luya
 */

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes, LogsActivity;

    protected static $logAttributes = ['first_name', 'last_name', 'email', 'user_name'];

    protected static $logName = 'user';

    public function getDescriptionForEvent(string $eventName): string
    {
        return "User has been {$eventName}";
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'user_name',
        'password',
        'phone',
        'profile_image',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $with =[
        'permissions',
        'roles'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'permission'
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPassword($token, $this));
    }

    public function getPermissionAttribute()
    {
        return $this->getAllPermissions();
    }

    public function billing_address()
    {
        return $this->hasOne('App\Services\UserAddressDetails\UserAddressDetail', 'user_id')->where('type', 1);
    }

    public function shipping_address()
    {
        return $this->hasOne('App\Services\UserAddressDetails\UserAddressDetail', 'user_id')->where('type', 2);
    }
}
