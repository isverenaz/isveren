<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Cv;
use App\Models\Job;
use App\Models\JobType;
use App\Notifications\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class CvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = $request['status'];
        if (!empty($status))
        {
            $status = ($status==1)? $status: 0;
            $cv = Cv::with('user','country','city','workingHour','category','parentCategory')->where(['status' => $status])->
            orderBy(DB::raw("DATE_FORMAT(created_at, '%y-%m-%d %H:%i:%s')"), 'DESC')->
            orderBy(DB::raw("DATE_FORMAT(created_at, '%d')"), 'DESC')->paginate(20);
        }else{
            $cv = Cv::with('user','country','city','workingHour','category','parentCategory')->
            orderBy(DB::raw("DATE_FORMAT(created_at, '%y-%m-%d %H:%i:%s')"), 'DESC')->
            orderBy(DB::raw("DATE_FORMAT(created_at, '%d')"), 'DESC')->paginate(20);
        }

        return view('admin.cv.index', compact('cv'));
    }

    public function status($id, Request $request)
    {
        $status = $request->status;
        $updated = Cv::where('id', $id)->update(['status' => !$status]);

        if (isset($updated) && !empty($updated)) {
            $userCv = Cv::where('id', $id)->first();
            if ($userCv->status == 1)
            {
                $message =  "Cv-niz dərc edildi";
            } else{
                $message =  "Cv-niz dərc edilmədi";
            }
            /*$mail_data = [
                'subject' => $message,
                'email' => 'enver.esgerov0106@gmail.com',//$userCv->email,
                'url' => 'https://isveren.az/cv-details/'.$id
            ];
            $email = Notification::route('mail', $mail_data['email'])->notify(new Mail($mail_data));
            */
            return true;
        } else {
            return false;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cv  $cv
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Cv::with('user','country','city','workingHour','category','parentCategory')->where('id',$id)->first();
        $cities = City::orderBy('name', 'ASC')->get();
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->get();
        $professions = Job::where('status', 1)->orderBy('title', 'ASC')->get();
        $subcategories = Category::whereNotNull('parent_id')->where('status', 1)->orderBy('name', 'ASC')->get();
        $types = JobType::orderBy('name', 'ASC')->get();
        return view('admin.cv.edit', compact('data','professions', 'cities', 'categories', 'types', 'subcategories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cv  $cv
     * @return \Illuminate\Http\Response
     */
    public function edit(Cv $cv)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cv  $cv
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cv $cv)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cv  $cv
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cv $cv)
    {
        //
    }
}
