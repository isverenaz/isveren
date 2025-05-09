<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobType extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'name' => 'array',
    ];

    public function job(): HasMany
    {
        return  $this->hasMany(Job::class, 'job_type_id', 'id')->where('jobs.status', 1);
    }
}
