<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobContact extends Model
{
    use HasFactory;

    protected $table = 'job_contacts';

    protected $fillable = [
        'company_id','job_id','user_id','fullname','resume','email','phone','messages','send_date','status'
    ];

    public function company(){
        return $this->hasOne(Company::class,'id','company_id');
    }

    public function job(){
        return $this->hasOne(Job::class,'id','job_id');
    }

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
