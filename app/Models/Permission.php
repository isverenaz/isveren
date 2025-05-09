<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;



class Permission extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function roles()
    {

        return $this->belongsToMany(Role::class, 'role_permissions');
    }

    public function users()
    {

        return $this->belongsToMany(User::class, 'users_permissions');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($permission) {
            $permission->slug = Str::slug($permission->name);
        });
    }
}
