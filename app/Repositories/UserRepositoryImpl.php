<?php

namespace App\Repositories;

use App\Contracts\UserRepository;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepositoryImpl implements UserRepository
{
    protected $model;
    protected $users;

    public function __construct()
    {
        $this->model = new User();
        $this->users = User::orderBy(DB::raw("DATE_FORMAT(created_at, '%y-%m-%d %H:%i:%s')"), 'DESC')->
        orderBy(DB::raw("DATE_FORMAT(created_at, '%d')"), 'DESC')->paginate(10);
    }

    public function findById($id)
    {
        return User::findOrFail($id);
    }

    public function create(array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->model->create($data);
    }

    public function update($user, $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
    }

    public function delete($id)
    {
        return $this->model->whereId($id)->delete();
    }
}
