<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    use HasFactory;


    protected $guarded = ['id'];

    protected $casts = [
        'name' => 'array',
    ];

    protected $fillable = [
        'name',
        'code',
        'status'
    ];
    public function city(): HasMany
    {
        return  $this->hasMany(Job::class, 'city_id', 'id')->where('status', 1);
    }
}
