<?php

namespace App\Repositories;

use App\Contracts\JobRepository;
use App\Models\Job;
use Illuminate\Support\Facades\DB;

class JobRepositoryImpl implements JobRepository
{
    protected $model;
    protected $jobType;


    public function __construct()
    {
        $this->model = new Job();
        $this->job = Job::orderBy(DB::raw("DATE_FORMAT(created_at, '%y-%m-%d %H:%i:%s')"), 'DESC')->
        orderBy(DB::raw("DATE_FORMAT(created_at, '%d')"), 'DESC')->paginate(10);
    }

    public function getAll($status)
    {
        if (!empty($status))
        {
            $status = ($status==1)? $status: 0;
            $job =  Job::where(['status' => $status])->orderBy(DB::raw("DATE_FORMAT(created_at, '%y-%m-%d %H:%i:%s')"), 'DESC')->
            orderBy(DB::raw("DATE_FORMAT(created_at, '%d')"), 'DESC')->paginate(10);
        } else {
            $job = $this->job;
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
