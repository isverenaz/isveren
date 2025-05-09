<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'blogs';

    protected $guarded = ['id'];

    protected $casts = [
        'title' => 'array',
        'description' => 'array'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function jobcategory()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');//->with('category');
    }

    public function subcategory()
    {
        return $this->hasOne(Category::class, 'id', 'sub_category_id');//->with('category');
    }
}
