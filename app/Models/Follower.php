<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
    public function job(){
        return $this->hasOne(Job::class,'id','job_id')->with(['company','jobcategory','city','jobType']);
    }
}
