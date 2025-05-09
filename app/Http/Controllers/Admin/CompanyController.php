<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\CompanyHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use App\Models\Translation;
use App\Repositories\CompanyRepositoryImpl;
use App\Services\SearchEngine;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected $companyRepository;

    public function __construct(CompanyRepositoryImpl $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }

    public function index(Request $request)
    {
        $status = $request['status'];
        $companies = $this->companyRepository->getAll($status);
        return view('admin.company.index', compact('companies'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locales = Translation::where('status',1)->get();
        return view('admin.company.create',compact('locales'));
    }

    public function search()
    {
        $searchEngine = SearchEngine::getInstance();
        $searchColumns = ['name'];
        $results = $searchEngine->search(new Company, 'sdsc', $searchColumns);
        return $results;
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
            if ($this->companyRepository->create($companyData)) {
                return redirect()->route('admin.company.index')->with('success', 'Şirkət adı uğurla əlavə edildi');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Xəta baş verdi: ' . $e->getMessage());
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
    public function edit($id,Company $company)
    {
        $company = Company::findOrFail($id);
        $locales = Translation::where('status',1)->get();
        return view('admin.company.edit', compact('company','locales'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $companyRequest,$id, Company $company)
    {
        try {
            $companyData = CompanyHelper::prepareCompanyData($companyRequest);

            if ($this->companyRepository->update($id, $companyData)) {
                return redirect()->route('admin.company.index')
                    ->with('success', 'Şirkət adı uğurla dəyişdirildi');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }

    public function status($id, Request $request)
    {
//        dd($id);
        $status = $request->status;
        $updated = Company::where('id', $id)->update(['status' => !$status]);

        if (isset($updated) && !empty($updated)) {
            return true;
        } else {
            return false;
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

            $data = Company::where('id',$id)->first();
            if (!empty($data))
            {
                $id = $data->id;
                $this->companyRepository->delete($id);
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
