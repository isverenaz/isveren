<?php

namespace App\Repositories;

use App\Contracts\TranslationRepository;
use App\Models\Translation;

class TranslationRepositoryImpl implements TranslationRepository
{
    protected $model;
    protected $cities;


    public function __construct()
    {
        $this->model = new Translation();
        $this->translations = Translation::paginate(10);
    }

    public function getAll()
    {
        return $this->translations;
    }

    public function create(array $data)
    {
//        dd($data);
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        return $this->model->whereId($id)->update($data);
    }
}
