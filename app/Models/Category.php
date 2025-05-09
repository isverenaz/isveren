<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'name','code','parent_id'
    ];
    protected $casts = [
        'name' => 'array',
    ];

    public function jobCategory():HasMany
    {
        return $this->hasMany(JobCategory::class, 'category_id', 'id')
            ->select('job_categories.id', "job_categories.category_id", "job_categories.job_id")
            ->join('jobs', 'jobs.id', '=', 'job_categories.job_id')
            ->where('jobs.status',1);
    }

    public function subcategory():HasMany
    {
        return $this->hasMany(Category::class,'parent_id','id');
    }
}
