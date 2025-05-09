<?php

namespace App\Helpers;

use App\Http\Middleware\Admin;
use App\Models\Translation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class JobSeekerHelper
{
    public static function prepareJobData($request,$guard)
    {
        $titleData = [];
        $descriptionData = [];
        $locales = Translation::where('status',1)->get();

        foreach ($locales as $locale) {
            $code = isset($locale['code']) ? $locale['code'] : '';
            $titleData[$code] = $request->input("title.$code", '');
            $descriptionData[$code] = $request->input("description.$code", '');
        }

        if($request->hasFile('image')){
            $imageName = time().'.'.$request->image->extension();
            $image = $request->image->move(public_path('uploads/job-seeker'), $imageName);
            $imageImage = $image->getFilename();
        }else{
            $imageImage = NULL;
        }

        if($request->hasFile('resume')){
            $resumeName = time().'.'.$request->resume->extension();
            $resume = $request->resume->move(public_path('uploads/job-seeker'), $resumeName);
            $resumeImage = $resume->getFilename();
        }else{
            $resumeImage = NULL;
        }

        $user_id = auth()->guard($guard)->user()->id;
        $salary = $request->min_salary ."-".$request->max_salary;
        $jobData = [
            'user_id' => $user_id,
            'category_id' => $request->category_id,
            'sub_category_id' => (isset($request->sub_category_id)? $request->sub_category_id : NULL),
            'job_type_id' => $request->job_type_id,
            'image' => $imageImage,
            'resume' => $resumeImage,
            'title' => $titleData,
            'description' => $descriptionData,
            'status' => $request->status === 'on' ? 1 : 0,
            'price' => (isset($request->price)? $request->price : $salary),
            'created_at' => (isset($request->created_at)? $request->created_at: Carbon::now()),
            'updated_at' => (isset($request->updated_at)? $request->updated_at: Carbon::now()),
        ];

//        dd($jobData);
        return $jobData;
    }
}
