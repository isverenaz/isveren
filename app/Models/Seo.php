<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    use HasFactory;

    protected $table = 'seo';

    protected $fillable = [
        'sub_id',
        'sub_table',
        'meta_title',
        'meta_description',
        'meta_keyword'
    ];

    protected $casts = [
        'meta_title' => 'array',
        'meta_description' => 'array',
        'meta_keyword' => 'array',
    ];
}
