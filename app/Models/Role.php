<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Str;

class Role extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function permissions()
    {

        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public function users()
    {

        return $this->belongsToMany(User::class, 'users_roles');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($role) {
            $role->slug = Str::slug($role->name);
        });
    }
}
