<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Laravel\Scout\Searchable;


class Job extends Model
{
    use HasFactory, Searchable;

    protected $table = 'jobs';
    public $timestamps = false;

    // protected $fillable = [
    //     'city_id',
    //     'job_type_id',
    //     'company_id',
    //     'title',
    //     'description',
    //     'price',
    //     'logo',
    //     'user_id'
    // ];
    protected $guarded = ['id'];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'seniority' => 'array'
    ];

    public function jobcategory()
    {
        return $this->hasOne(JobCategory::class, 'job_id', 'id')->with(['category','subcategory']);
    }

    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }

    public function jobType()
    {
        return $this->hasOne(JobType::class, 'id', 'job_type_id');
    }

    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }

    public function jobUser()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function jobContact()
    {
        return $this->hasMany(JobContact::class, 'job_id', 'id');
    }

    public function jobSeo()
    {
        return $this->hasOne(Seo::class, 'sub_id', 'id');
    }

    public function toSearchableArray()
    {
        return [
            'price' => $this->price,
            'title' => $this->title,
        ];
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'job_categories');
    }
    public function follower()
    {
        return $this->hasMany(Follower::class);
    }
}
