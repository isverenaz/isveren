<?php

namespace App\Repositories;

use App\Contracts\CompanyRepository;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompanyRepositoryImpl implements CompanyRepository
{
    protected $model;
    protected $jobType;


    public function __construct()
    {
        $this->model = new Company();
        $this->company = Company::orderBy(DB::raw("DATE_FORMAT(created_at, '%y-%m-%d')"), 'DESC')->orderBy(DB::raw("DATE_FORMAT(created_at, '%d')"), 'DESC')->paginate(10);
    }

    public function getAll($status)
    {
        if (!empty($status))
        {
            $status = ($status==1)? $status: 0;
            $job =  Company::where(['status' => $status])->orderBy(DB::raw("DATE_FORMAT(created_at, '%y-%m-%d')"), 'DESC')->orderBy(DB::raw("DATE_FORMAT(created_at, '%d')"), 'DESC')->paginate(10);
        } else {
            $job = $this->company;
        }
        return $job;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        return $this->model->whereId($id)->update($data);
    }

    public function delete($id)
    {
        return $this->model->whereId($id)->delete();
    }
}
