<?php

namespace App\Contracts;

interface BlogRepository
{
    public function getAll($status);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
