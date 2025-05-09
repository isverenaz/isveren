<?php

namespace App\Repositories;

use App\Contracts\JobTypeRepository;
use App\Models\JobType;

class JobTypeImpl implements JobTypeRepository
{
    protected $model;
    protected $jobType;


    public function __construct()
    {
        $this->model = new JobType();
        $this->jobType = JobType::paginate(10);
    }

    public function getAll()
    {
        return $this->jobType;
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
