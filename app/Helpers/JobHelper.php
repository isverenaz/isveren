<?php

namespace App\Helpers;

use App\Http\Middleware\Admin;
use App\Models\Translation;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;

class JobHelper
{
    public static function prepareJobData($request, $guard)
    {
        $titleData = [];
        $descriptionData = [];
        $locales = Translation::where('status', 1)->get();

        foreach ($locales as $locale) {
            $code = isset($locale['code']) ? $locale['code'] : '';
            $titleData[$code] = $request->input("title.$code", '');
            $descriptionData[$code] = $request->input("description.$code", '');
        }

        $user_id = !empty($request->user_id)? $request->user_id: auth()->guard($guard)->user()->id;

        $salary = ($request->min_salary ?? 0). "-" . $request->max_salary;

        $start_date = isset($request->start_date)
            ? DateTime::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d')
            : Carbon::now()->format('Y-m-d');
        $end_date = isset($request->end_date)
            ? DateTime::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d')
            : Carbon::now()->format('Y-m-d');
        $jobData = [
            'title' => $titleData,
            'description' => $descriptionData,
            'status' => 0,
            'price' => (isset($request->price) ? $request->price : $salary),
            'user_id' => $user_id,
            'city_id' => $request->city_id,
            'company_id' => $request->company_id,
            'job_type_id' => $request->job_type_id,
            'email' => $request->email ?? '',
            'phone' => $request->phone ?? '',
            'is_premium' => $request->is_premium ?? 0,
            'is_new' => $request->is_new ?? 0,
            'is_top' => $request->is_top ?? 0,
            'is_featured' => $request->is_featured ?? 0,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'created_at' => $start_date.' 00:00:00',
            'updated_at' => $end_date.' 00:00:00',
        ];

        return $jobData;
    }
}
