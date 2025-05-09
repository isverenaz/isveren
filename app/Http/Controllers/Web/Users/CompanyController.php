<?php

namespace App\Http\Controllers\Web\Users;

use App\Helpers\CompanyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobCategory;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->guard('web')->user();
        $companies = Company::where('user_id', $user->id)->orderBy('id','DESC')->paginate(5);
        return view('web.users.company.list', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('web.users.company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $companyRequest)
    {
        try {
            $companyData = CompanyHelper::prepareCompanyData($companyRequest);
            $companySaveData  = Company::create($companyData);
            if (!empty($companySaveData->id)) {
                return ['success' => true, 'message' => 'Şirkət uğurla əlavə edildi'];
            }else {
                return ['success' => false, 'errors' => 'Şirkət uğurla əlavə edilmedi'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'errors' => 'Xəta baş verdi: ' . $e->getMessage()];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = auth()->guard('web')->user();
        $company = Company::where(['user_id' => $user->id, 'id' => $id])->first();
        return view('web.users.company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $companyRequest,$id)
    {
        try {
            $user = auth()->guard('web')->user();
            $company = Company::where(['user_id' => $user->id, 'id' => $id])->first();
            $companyData = CompanyHelper::prepareCompanyData($companyRequest,$company);
            Company::where(['user_id' => $user->id, 'id' => $id])->update($companyData);
            return ['success' => true, 'message' => 'Şirkət uğurla yenilənmə edildi'];
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Xəta baş verdi: ' . $e->getMessage()];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = auth()->guard('web')->user();
            $company = Company::where(['user_id' => $user->id, 'id' => $id])->first();
            if ($company) {
                $jobs = Job::where('company_id', $company->id)->get();
                if ($jobs) {
                    foreach ($jobs as $job) {
                        $jobCat = JobCategory::where('job_id', $job->id)->first();
                        if ($jobCat) {
                            $jobCat->delete();
                            continue;
                        }else{
                            break;
                        }
                    }
                    Job::where('company_id', $company->id)->delete();
                }
                Company::where(['user_id' => $user->id, 'id' => $id])->delete();
                return ['success' => true, 'message' => 'Şirkət uğurla levg edildi'];
            }else{
                return ['success' => true, 'message' => 'Şirkət uğurla levg edilmedi.'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'Xəta baş verdi: ' . $e->getMessage()];
        }
    }
}
