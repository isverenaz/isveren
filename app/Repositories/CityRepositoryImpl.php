<?php

namespace App\Repositories;

use App\Contracts\CityRepository;
use App\Models\City;
use Illuminate\Http\Client\Request;

class CityRepositoryImpl implements CityRepository
{
    protected $model;
    protected $cities;


    public function __construct()
    {
        $this->model = new City();
        $this->cities = City::paginate(10);
    }

    public function getAll()
    {
        return $this->cities;
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
