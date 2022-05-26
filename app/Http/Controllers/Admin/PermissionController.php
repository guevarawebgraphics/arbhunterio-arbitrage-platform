<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\PermissionGroups\Repositories\PermissionGroupRepositoryInterface;
use App\Services\Permissions\Repositories\PermissionRepositoryInterface;
use App\Services\Roles\Repositories\RoleRepositoryInterface;
use App\Services\Permissions\Requests\addPermissionRequest;
use App\Services\Permissions\Requests\updatePermissionRequest;

use DB;

/**
 * Class PermissionController
 * @package App\Http\Controllers
 * @author Richard Guevara
 */

class PermissionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Permission Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles permissions.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @param RoleRepositoryInterface $RoleRepositoryInterface
     * @param PermissionRepository $PermissionRepositoryInterface
     * @param PermissionGroupRepository $PermissionGroupRepositoryInterface
     */

    public function __construct(RoleRepositoryInterface $roleRepository,
        PermissionGroupRepositoryInterface $permissionGroupRepository,
        PermissionRepositoryInterface $permissionsRepository
    )
    {
        /*
        * Repository namespace
        * this class may include methods that can be used by other controllers, like getting of posts with other data (related tables).
        * */
        $this->permissionGroupRepository = $permissionGroupRepository;
        $this->permissionsRepository = $permissionsRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('Read Permission')) {
            abort('401', '401');
        }

        $permissions = $this->permissionGroupRepository->getAllWithPermissions();

        if ($request->ajax()) {
            $data = $this->permissionsRepository->all();
            return datatables()->of($data)
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (auth()->user()->can('Update Permission')) {
                        $html = '<a href="' . route('admin.permissions.edit', $row->id) . '" class="btn btn-primary btn-edit">Edit</a> ';
                    }
                    if (auth()->user()->can('Delete Permission')) {
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-delete">Delete</button>';
                    }
                    return $html;
                })->toJson();
        }

        return view('admin.pages.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('Create Permission')) {
            abort('401', '401');
        }

        $roles = $this->roleRepository->all();
        $permission_groups = $this->permissionGroupRepository->all();

        return view('admin.pages.permissions.create', compact('roles', 'permission_groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(addPermissionRequest $request)
    {
        if (!auth()->user()->hasPermissionTo('Create Permission')) {
            abort('401', '401');
        }

        $this->permissionsRepository->addPermission($request->only('name', 'permission_group_id'));
        return redirect()->route('admin.permissions.index')->with('success','Permission created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->hasPermissionTo('Update Permission')) {
            abort('401', '401');
        }
        
        $permission = $this->permissionsRepository->get($id);
        $roles = $this->roleRepository->all();
        $permission_groups = $this->permissionGroupRepository->all();

        return view('admin.pages.permissions.edit', compact('permission', 'roles', 'permission_groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(updatePermissionRequest $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('Update Permission')) {
            abort('401', '401');
        }

        $input = $request->only(['name', 'permission_group_id']);
        $this->permissionsRepository->updatePermission($id, $input);

        return redirect()->route('admin.permissions.index')->with('success','Permissions updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->hasPermissionTo('Delete Permission')) {
            abort('401', '401');
        }

        return $this->permissionsRepository->delete($id);
    }
}
