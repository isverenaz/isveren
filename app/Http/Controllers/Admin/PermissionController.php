<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Repositories\PermissionRepositoryImpl;
use App\Services\SearchEngine;
use App\Http\Requests\PermissionRequest;
use App\Models\Role;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $permissionRepository;

    public function __construct(PermissionRepositoryImpl $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }
    /**
     * Display a listing of the resource.git 
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions = $this->permissionRepository->getAll();
        return view('admin.permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permission.create');
    }

    public function search()
    {
        $searchEngine = SearchEngine::getInstance();
        $searchColumns = ['name'];
        $results = $searchEngine->search(new Permission(), 'sdsc', $searchColumns);
        return $results;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $permissionRequest)
    {
        $role = [];

        if (!empty($permissionRequest->roles) && is_array($permissionRequest->roles)) {
            $role = Role::whereIn('slug', $permissionRequest->roles)->get();
        }

        try {
            $result = $this->permissionRepository->create(['name' => $permissionRequest->name]);

            if ($result) {
                if (!empty($role)) {
                    $result->roles()->attach($role);
                }

                return redirect()->route('admin.permission.index')
                    ->with('success', 'Role adı uğurla əlavə edildi');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\JobType  $jobType
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\JobType  $jobType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('admin.permission.edit', compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\JobType  $jobType
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request, $id)
    {
        $permission = Permission::findOrFail($id);
        try {
            $result = $this->permissionRepository->update($permission->id, ['name' => $request->name]);
            if (!$result) {
                return redirect()->route('admin.permission.index')
                    ->with('success', 'Role adı uğurla dəyişdirildi');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Xəta baş verdi: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\JobType  $jobType
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $role)
    {
        //
    }
}
