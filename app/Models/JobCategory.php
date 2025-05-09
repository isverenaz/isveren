<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class JobCategory extends Model
{
    use HasFactory;

    protected $table = 'job_categories';

    protected $fillable = [
        'job_id','category_id','sub_category_id'
    ];

    public function category()
    {
        return $this->hasOne(Category::class,'id','category_id');
    }
    public function subcategory()
    {
        return $this->hasOne(Category::class,'id','sub_category_id');
    }

    public function job():HasOne
    {
        return $this->hasOne(Job::class,'id','job_id')->where('status',1);
    }
}
