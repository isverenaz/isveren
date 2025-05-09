<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\JobHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\JobRequest;
use App\Models\Category;
use App\Models\City;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\JobType;
use App\Models\Translation;
use App\Models\User;
use App\Repositories\JobRepositoryImpl;
use App\Services\SearchEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    protected $jobRepository;

    public function __construct(JobRepositoryImpl $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    public function index(Request $request)
    {
        $status = $request['status'];
        $jobs = $this->jobRepository->getAll($status);
        return view('admin.jobs.index', compact('jobs'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::where('status',1)->orderBy('name', 'ASC')->get();
        $users = User::where('status',1)->orderBy('name', 'ASC')->get();
        $companies = Company::where('status',1)->orderBy('name', 'ASC')->get();
        $categories = Category::where('status',1)->orderBy('name', 'ASC')->get();
        $types = JobType::where('status',1)->orderBy('name', 'ASC')->get();
        $locales = Translation::where('status',1)->get();
        return view('admin.jobs.create', compact('companies', 'cities', 'users', 'categories', 'types','locales'));
    }

    public function status($id, Request $request)
    {
        //        dd($id);
        $status = $request->status;
        $updated = Job::where('id', $id)->update(['status' => !$status]);

        if (isset($updated) && !empty($updated)) {
            return true;
        } else {
            return false;
        }
    }

    public function search()
    {
        $searchEngine = SearchEngine::getInstance();
        $searchColumns = ['name'];
        $results = $searchEngine->search(new Job(), 'sdsc', $searchColumns);
        return $results;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobRequest $jobRequest)
    {
        try {
            $guard = 'customer';
            $jobData = JobHelper::prepareJobData($jobRequest,$guard);
            $this->jobRepository->create($jobData);
            $job_id = DB::getPdo()->lastInsertId();
            if ($job_id) {
                JobCategory::create(['job_id' => $job_id, 'category_id' => $jobRequest->category_id]);
                return redirect()->route('admin.jobs.index')->with('success', 'Vakansya adı uğurla əlavə edildi');
            }else{
                return redirect()->route('admin.jobs.index')->with('success', 'Vakansya adı uğurla əlavə edilmədi');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Job $job)
    {
        $job = Job::with('jobcategory')->where('id', $id)->first();

        $cities = City::orderBy('name', 'ASC')->get();
        $users = User::where('status',1)->orderBy('name', 'ASC')->get();
        $companies = Company::where('status',1)->orderBy('name', 'ASC')->get();
        $categories = Category::where('status',1)->orderBy('name', 'ASC')->get();
//        dd($job->jobcategory->category_id);
        $types = JobType::where('status',1)->orderBy('name', 'ASC')->get();
        $locales = Translation::where('status',1)->get();
        return view('admin.jobs.edit', compact('job', 'companies', 'cities', 'users', 'categories', 'types','locales'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(JobRequest $jobRequest, $id, Job $job)
    {
        try {
            $guard = 'customer';
            $jobData = JobHelper::prepareJobData($jobRequest,$guard);

            if ($this->jobRepository->update($id, $jobData)) {
                JobCategory::where('job_id', $id)->update(['category_id' => $jobRequest->category_id]);
                return redirect()->route('admin.jobs.index')
                    ->with('success', 'Vakansya adı uğurla dəyişdirildi');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $jobCategory = JobCategory::where('job_id',$id)->delete();
            if (!empty($jobCategory))
            {

                $job = Job::where('id',$id)->first();
                $id = $job->id;
                $this->jobRepository->delete($id);
                $message = 'Məlumat silindi.';
            }else{
                $message = 'Məlumatın kategoryası olduqu üçün silinmədi.';
            }
            return redirect()->back()->with('success', $message);
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Xətta baş verdi.-'.$exception->getMessage());
        }
    }
}
