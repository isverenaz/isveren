<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSeeker extends Model
{
    use HasFactory;

    protected $table = 'job_seekers';

     protected $fillable = [
         'user_id',
         'admin_id',
         'category_id',
         'sub_category_id',
         'type_id',
         'image',
         'resume',
         'position',
         'skills',
         'experiences',
         'educations',
         'contact',
         'overview',
         'awards_certificates',
         'overview',
         'full_text',
         'status',
         'reads',
         'created_at',
         'updated_at'
     ];
    protected $guarded = ['id'];

    protected $casts = [
        'position' => 'array',
        'skills' => 'array',
        'experiences' => 'array',
        'educations' => 'array',
        'contact' => 'array',
        'overview' => 'array',
        'awards_certificates' => 'array',
        'full_text' => 'array'
    ];

    public function jobcategory()
    {
        return $this->hasOne(JobCategory::class, 'job_id', 'id')->with('category');
    }

    public function jobType()
    {
        return $this->hasOne(JobType::class, 'id', 'job_type_id');
    }

    public function jobUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function jobSeo()
    {
        return $this->hasOne(Seo::class, 'sub_id', 'id');
    }
}
