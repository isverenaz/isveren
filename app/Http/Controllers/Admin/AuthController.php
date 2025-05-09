<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Repositories\PermissionRepositoryImpl;
use App\Repositories\RoleRepositoryImpl;
use App\Repositories\UserRepositoryImpl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    protected $userRepository;
    protected $roleRepository;
    protected $permissionRepository;

    public function __construct(UserRepositoryImpl $userRepository, RoleRepositoryImpl $roleRepository, PermissionRepositoryImpl $permissionRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }


    public function index()
    {
        $users = User::when(request('search'), function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('surname', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
        })->when(request('status'), function ($query, $status) {
            $query->where('status', $status);
        })->when(request('role'), function ($query, $roleSlug) {
                $query->whereHas('roles', function ($roleQuery) use ($roleSlug) {
                    $roleQuery->where('slug', $roleSlug);
                });
            })->orderBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s')"), 'DESC')
            ->orderBy(DB::raw("DAY(created_at)"), 'DESC')
            ->paginate(10);
        $userCount = User::when(request('search'), function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('surname', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%");
        })->when(request('status'), function ($query, $status) {
            $query->where('status', $status);
        })->when(request('role'), function ($query, $roleSlug) {
                $query->whereHas('roles', function ($roleQuery) use ($roleSlug) {
                    $roleQuery->where('slug', $roleSlug);
                });
            })->orderBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d %H:%i:%s')"), 'DESC')
            ->orderBy(DB::raw("DAY(created_at)"), 'DESC')
            ->count();
        return view('admin.user.index', compact('users','userCount'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(UserRequest $request)
    {
        try {
            $userData = $request->validated();
            $user = $this->userRepository->create($userData);

            if ($request->has('role')) {
                $roles = $this->roleRepository->findBySlugs($request->role);
                $user->roles()->attach($roles);
            }

            if ($request->has('permission')) {
                $permissions = $this->permissionRepository->findBySlugs($request->permission);
                $user->permissions()->attach($permissions);
            }
            return redirect()->route('admin.user.index');
        } catch (\Exception $e) {
            return back()->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $user =  User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $user = $this->userRepository->findById($id);

            if ($request->has('role')) {
                $roles = $this->roleRepository->findBySlugs($request->role);
                $user->roles()->sync($roles);
                return redirect()->route('admin.user.index');
            }

            if ($request->has('permission')) {
                $permissions = $this->permissionRepository->findBySlugs($request->permission);
                $user->permissions()->sync($permissions);
            }

            $this->userRepository->update($user, $request->only(['name', 'surname', 'email', 'password']));

            return redirect()->route('admin.user.index');
        } catch (\Exception $e) {
            return back()->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {

            $data = User::where('id',$id)->first();
            if (!empty($data))
            {
                $id = $data->id;
                $this->userRepository->delete($id);
                $message = 'Məlumat silindi.';
            }else{
                $message = 'Məlumatın tapilmadiqi üçün silinmədi.';
            }
            return redirect()->back()->with('success', $message);
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Xətta baş verdi.-'.$exception->getMessage());
        }
    }
}
