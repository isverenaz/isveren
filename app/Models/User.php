<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\HasPermissionsTrait;



class User extends Authenticatable
{
    use HasApiTokens, HasPermissionsTrait, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles', 'user_id', 'role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'users_permissions', 'user_id', 'permission_id');
    }

    public function role()
    {
        return $this->belongsToMany(Role::class, 'users_roles', 'user_id', 'role_id');
    }

    public function userRole()
    {
        return $this->hasOne(UserRole::class, 'user_id', 'id')->with('role');
    }

    public function followers()
    {
        return $this->hasMany(Follower::class, 'user_id')->orderBy('id', 'desc');
    }

    public function jobContact()
    {
        return $this->hasMany(JobContact::class, 'user_id')->where(['created_at'=>Carbon::now()])->with(['user'])->orderBy('id', 'desc');
    }
}
