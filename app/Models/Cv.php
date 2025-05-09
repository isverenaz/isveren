<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    use HasFactory;

    protected $table = 'cv';

    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'birthday',
        'gender_status',
        'married_status',
        'is_child',
        'country_id',
        'city_id',
        'permanent_address',
        'actual_address',
        'phone',
        'email',
        'category_id',
        'parent_category_id',
        'working_hour',
        'min_salary',
        'max_salary',
        'desired_address',
        'skills',
        'language',
        'experience',
        'education',
        'projects',
        'hobby',
        'socials',
        'resume',
        'motivation_letter',
        'note',
        'status',
        'is_new',
        'is_premium',
        'reads',
        'share'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function city()
    {
        return $this->hasOne(City::class, 'id', 'city_id');
    }


    public function workingHour()
    {
        return $this->hasOne(JobType::class, 'id', 'working_hour');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function parentCategory()
    {
        return $this->hasOne(Category::class, 'id', 'parent_category_id');
    }
}
