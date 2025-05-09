<?php

namespace App\Contracts;


interface PermissionRepository
{
    public function getAll();
    public function create(array $data);
    public function update($id, array $data);
}
