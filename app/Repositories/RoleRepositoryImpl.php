<?php

namespace App\Repositories;

use App\Contracts\RoleRepository;
use App\Models\Role;

class RoleRepositoryImpl implements RoleRepository
{
    protected $model;
    protected $roles;

    public function __construct()
    {
        $this->model = new Role();
        $this->roles = Role::paginate(10);
    }

    public function getAll()
    {
        return $this->roles;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $this->model->whereId($id)->update($data);
    }

    public function findBySlugs($slugs)
    {
        return Role::whereIn('slug', $slugs)->get();
    }
    public function findBySlug($slug)
    {
        return Role::where('slug', $slug)->first();
    }

    public function delete($id)
    {
        return $this->model->whereId($id)->delete();
    }
}
