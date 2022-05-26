<?php
    
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\PermissionGroups\Repositories\PermissionGroupRepositoryInterface;
use App\Services\Permissions\Repositories\PermissionRepositoryInterface;
use App\Services\Roles\Repositories\RoleRepositoryInterface;
use App\Services\Roles\Requests\addRoleRequest;
use App\Services\Roles\Requests\updateRoleRequest;
use DB;
    
class RoleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @param PermissionGroupRepositoryInterface $permissionGroupRepository
     */
    function __construct(
        PermissionGroupRepositoryInterface $permissionGroupRepository,
        PermissionRepositoryInterface $permissionRepository,
        RoleRepositoryInterface $roleRepository
    )
    {
        $this->permissionGroupRepository = $permissionGroupRepository;
        $this->permissionRepository = $permissionRepository;
        $this->roleRepository = $roleRepository;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('Read Role')) {
            abort('401', '401');
        }

        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());
        if ($request->ajax()) {
            $data = $this->roleRepository->all();
            return datatables()->of($data)
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (auth()->user()->can('Update Role')) {
                        $html = '<a href="' . route('admin.roles.edit', $row->id) . '" class="btn btn-primary btn-edit">Edit</a> ';
                    }
                    if (auth()->user()->can('Delete Role')) {
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-delete">Delete</button>';
                    }
                    return $html;
                })->toJson();
        }

        return view('admin.pages.roles.index', compact('permissions'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('Create Role')) {
            abort('401', '401');
        }

        $permission = $this->permissionRepository->all();
        $permission_groups = $this->permissionGroupRepository->getAllWithPermissions();
        return view('admin.pages.roles.create',compact('permission', 'permission_groups'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(addRoleRequest $request)
    {
        $role = $this->roleRepository->addRole(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
    
        return redirect()->route('admin.roles.index')->with('success','Role created successfully');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->hasPermissionTo('Update Role')) {
            abort('401', '401');
        }

        $role = $this->roleRepository->get($id);
        $permission = $this->permissionRepository->all();
        $permission_groups = $this->permissionGroupRepository->getAllWithPermissions();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
    
        return view('admin.pages.roles.edit',compact('role','permission','rolePermissions', 'permission_groups'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updateRoleRequest $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('Update Role')) {
            abort('401', '401');
        }
        
        $role = $this->roleRepository->updateRole($id, ['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));
    
        return redirect()->route('admin.roles.index')->with('success','Role updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->hasPermissionTo('Delete Role')) {
            abort('401', '401');
        }

        return $this->roleRepository->delete($id);
    }

}