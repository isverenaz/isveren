<?php

namespace App\Repositories;

use App\Contracts\PermissionRepository;
use App\Models\Permission;

class PermissionRepositoryImpl implements PermissionRepository
{
    protected $model;
    protected $roles;

    public function __construct()
    {
        $this->model = new Permission();
        $this->roles = Permission::paginate();
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
        return Permission::whereIn('slug', $slugs)->get();
    }
}
