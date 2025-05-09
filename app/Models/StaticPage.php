<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    use HasFactory;

    protected $table = 'static_pages';
//    protected $guarded = ['id'];

    protected $fillable = [
        'title',
        'text',
        'image',
        'type'
    ];
    protected $casts = [
        'title' => 'array',
        'text' => 'array'
    ];
}
