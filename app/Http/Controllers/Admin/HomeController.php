<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Follower;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $jobs = Job::all();
        $followers = Follower::all();
        $users = User::all();
        return view('admin.home',compact('jobs','followers','users'));
    }
    public function contact()
    {
        $contacts = Contact::orderBy('id','desc')->get();
        return view('admin.contact',compact('contacts'));
    }
}
