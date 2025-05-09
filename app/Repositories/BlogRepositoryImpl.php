<?php

namespace App\Repositories;

use App\Contracts\BlogRepository;
use App\Models\Blog;
use Illuminate\Support\Facades\DB;

class BlogRepositoryImpl implements BlogRepository
{
    protected $model;
    protected $jobType;


    public function __construct()
    {
        $this->model = new Blog();
        $this->blog = Blog::orderBy(DB::raw("DATE_FORMAT(created_at, '%y-%m-%d')"), 'DESC')->
                        orderBy(DB::raw("DATE_FORMAT(created_at, '%d')"), 'DESC')->paginate(10);
    }

    public function getAll($status)
    {
        if (!empty($status))
        {
            $status = ($status==1)? $status: 0;
            $blog =  Blog::where(['status' => $status])->
                        orderBy(DB::raw("DATE_FORMAT(created_at, '%y-%m-%d')"), 'DESC')->paginate(10);
        } else {
            $blog = $this->blog;
        }
        return $blog;
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
