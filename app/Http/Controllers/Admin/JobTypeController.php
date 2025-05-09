<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\JobTypeHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\JobTypeRequest;
use App\Models\JobType;
use App\Models\Translation;
use App\Repositories\JobTypeImpl;
use App\Services\SearchEngine;
use Illuminate\Http\Request;

class JobTypeController extends Controller
{
    protected $jobTypeRepository;

    public function __construct(JobTypeImpl $jobTypeRepository)
    {
        $this->jobTypeRepository = $jobTypeRepository;
    }
    /**
     * Display a listing of the resource.git
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobType = $this->jobTypeRepository->getAll();
        return view('admin.job-type.index', compact('jobType'));
    }

    public function status($id, Request $request)
    {
//        dd($id);
        $status = $request->status;
        $updated = JobType::where('id', $id)->update(['status' => !$status]);

        if (isset($updated) && !empty($updated)) {
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
        $locales = Translation::where('status',1)->get();
        return view('admin.job-type.create',compact('locales'));
    }

    public function search()
    {
        $searchEngine = SearchEngine::getInstance();
        $searchColumns = ['name'];
        $results = $searchEngine->search(new JobType, 'sdsc', $searchColumns);
        return $results;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobTypeRequest $jobTypeRequest)
    {
        try {
            $jobTypeData = JobTypeHelper::prepareJobTypeData($jobTypeRequest);

            if ($this->jobTypeRepository->create($jobTypeData)) {
                return redirect()->route('admin.job-type.index')
                    ->with('success', 'Tip adı uğurla əlavə edildi');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobType  $jobType
     * @return \Illuminate\Http\Response
     */
    public function show(JobType $jobType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobType  $jobType
     * @return \Illuminate\Http\Response
     */
    public function edit($id,JobType $jobType)
    {
        $locales = Translation::where('status',1)->get();
        $jobType =  JobType::findOrFail($id);
        return view('admin.job-type.edit', compact('jobType','locales'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobType  $jobType
     * @return \Illuminate\Http\Response
     */
    public function update(JobTypeRequest $request, $id,JobType $jobType)
    {
//        dd('salam');
        try {
            $jobTypeData = JobTypeHelper::prepareJobTypeData($request);

            if ($this->jobTypeRepository->update($id, $jobTypeData)) {
                return redirect()->route('admin.job-type.index')
                    ->with('success', 'Tip adı uğurla dəyişdirildi');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobType  $jobType
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $data = JobType::where('id',$id)->first();
            if (!empty($data))
            {
                $id = $data->id;
                $this->jobTypeRepository->delete($id);
                $message = 'Məlumat silindi.';
            }else{
                $message = 'Məlumatın tapilmadiqi üçün silinmədi.';
            }
            return redirect()->back()->with('success', $message);
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Xətta baş verdi.-'.$exception->getMessage());
        }
    }
}
