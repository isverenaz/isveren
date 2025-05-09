<?php

namespace App\Http\Controllers\Web\Users;

use App\Helpers\JobHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\JobRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobType;
use App\Models\User;
use App\Repositories\JobRepositoryImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{

    public function index()
    {
        $user = auth()->guard('web')->user();
        $jobs = Job::with('company', 'city', 'jobType')->where('user_id', $user->id)->orderBy('id','DESC')->get();//paginate(10);
        return view('web.users.jobs.list', compact('jobs'));
    }

    public function create()
    {
        $cities = City::where('status', 1)->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.az')) ASC")->get();
        $users = User::orderBy('name', 'ASC')->get();
        $user_id = auth()->guard('web')->user();
        $companies = Company::orderBy('name', 'ASC')->where('user_id', $user_id->id)->get();
        $categories = Category::with('jobCategory', 'subcategory')
            ->where('status', 1)
            ->whereNull('parent_id')
            ->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.az')) ASC")
            ->get();
        $subcategories = Category::whereNotNull('parent_id')->where('status', 1)->orderBy('name', 'ASC')->get();
        $types = JobType::where('status', 1)->orderBy('name', 'ASC')->get();
        return view('web.users.jobs.create', compact('companies', 'cities', 'users', 'categories', 'types', 'subcategories'));
    }

    public function store(JobRequest $jobRequest)
    {
        try {
            $guard = 'web';
            $jobData = JobHelper::prepareJobData($jobRequest, $guard);
            $job  = Job::create($jobData);
            if (!empty($job->id)) {
                JobCategory::create(['job_id' => $job->id, 'category_id' => $jobRequest->category_id, 'sub_category_id' => $jobRequest->sub_category_id]);
                return ['success' => true, 'message' => 'Vakansiya uğurla əlavə edildi'];
            }else {
                return ['success' => false, 'error' => 'Vakansiya uğurla əlavə edilmedi'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Xəta baş verdi: ' . $e->getMessage()];
        }
    }

    public function edit($id)
    {
        $job = Job::with('jobcategory')->where('id', $id)->first();
        $cities = City::where('status', 1)->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.az')) ASC")->get();
        $users = User::orderBy('name', 'ASC')->get();
        $user_id = auth()->guard('web')->user();
        $companies = Company::orderBy('name', 'ASC')->where('user_id', $user_id->id)->get();
        $categories = Category::with('jobCategory', 'subcategory')
            ->where('status', 1)
            ->whereNull('parent_id')
            ->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.az')) ASC")
            ->get();
        $subcategories = Category::where('status', 1)->whereNotNull('parent_id')->orderBy('name', 'ASC')->get();
        $types = JobType::where('status', 1)->orderBy('name', 'ASC')->get();

        return view('web.users.jobs.edit', compact('job', 'companies', 'cities', 'users', 'categories', 'types', 'subcategories'));
    }

    public function update(JobRequest $jobRequest, $id)
    {
        try {
            $guard = 'web';
            $jobData = JobHelper::prepareJobData($jobRequest, $guard);

            if (Job::where('id', $id)->first()) {
                Job::where('id', $id)->update($jobData);
                JobCategory::where('job_id', $id)->update(['category_id' => $jobRequest->category_id, 'sub_category_id' => $jobRequest->sub_category_id]);
                return ['success' => true, 'message' => 'Vakansiya uğurla dəyişiklik edildi'];
            }else {
                return ['success' => false, 'error' => 'Vakansiya uğurla dəyişiklik edilmedi'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Xəta baş verdi: ' . $e->getMessage()];
        }
    }

    public function destroy($id)
    {
        try {
            $user = auth()->guard('web')->user();
            $job = Job::where(['user_id' => $user->id, 'id' => $id])->first();
            if ($job) {
                $jobCategory = JobCategory::where('job_id', $job->id)->get();
                if (!empty($jobCategory[0])) {
                    JobCategory::where('job_id', $job->id)->delete();
                }
                Job::where(['user_id' => $user->id, 'id' => $id])->delete();
                return ['success' => true, 'message' => 'Vakansiya uğurla levg edildi'];
            }else{
                return ['success' => true, 'message' => 'Vakansiya uğurla levg edilmedi.'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'error' => ['Xəta baş verdi: ' . $e->getMessage()]];
        }
    }

    public function subCategory($id)
    {
        $subcategories = Category::whereNotNull('parent_id')
            ->where(['parent_id'=>$id,'status'=>1])
            ->orderByRaw("JSON_UNQUOTE(JSON_EXTRACT(name, '$.az')) ASC")
            ->get();
        return response()->json($subcategories);
    }
}
