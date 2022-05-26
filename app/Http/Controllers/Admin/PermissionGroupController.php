<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\PermissionGroups\Repositories\PermissionGroupRepositoryInterface;
use App\Services\PermissionGroups\Requests\addPermissionGroupRequest;
use App\Services\PermissionGroups\Requests\updatePermissionGroupRequest;
use DB;

/**
 * Class PermissionGroupController
 * @package App\Http\Controllers
 * @author Richard Guevara
 */
class PermissionGroupController extends Controller
{
    //
    /*
    |--------------------------------------------------------------------------
    | Permission Group Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles permission_groups.
    |
    */

    public function __construct(PermissionGroupRepositoryInterface $permissionGroupRepository)
    {
        $this->permissionGroupRepository = $permissionGroupRepository;
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function index(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('Read Permission Group')) {
            abort('401', '401');
        }

        $permission_groups = $this->permissionGroupRepository->getAllWithPermissions();
        if ($request->ajax()) {
            $data = $permission_groups;
            return datatables()->of($data)
                ->addColumn('permissions', function ($row) {
                    return $row->permissions->pluck('name')->implode(', ');
                })
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (auth()->user()->can('Update Permission Group')) {
                        $html = '<a href="' . route('admin.permission_groups.edit', $row->id) . '" class="btn btn-primary btn-edit">Edit</a> ';
                    }
                    if (auth()->user()->can('Delete Permission Group')) {
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-delete">Delete</button>';
                    }
                    return $html;
                })->toJson();
        }

        return view('admin.pages.permission_groups.index', compact('permission_groups'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('Create Permission Group')) {
            abort('401', '401');
        }

        return view('admin.pages.permission_groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(addPermissionGroupRequest $request)
    {
        if (!auth()->user()->hasPermissionTo('Create Permission Group')) {
            abort('401', '401');
        }

        $this->permissionGroupRepository->addPermissionGroup($request->only('name'));
        return redirect()->route('admin.permission_groups.index')->with('success','Permission group created successfully');
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
        if (!auth()->user()->hasPermissionTo('Update Permission Group')) {
            abort('401', '401');
        }

        $permission_group = $this->permissionGroupRepository->get($id);

        return view('admin.pages.permission_groups.edit', compact('permission_group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(updatePermissionGroupRequest $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('Update Permission Group')) {
            abort('401', '401');
        }

        $input = $request->only(['name']);
        $permission_group = $this->permissionGroupRepository->updatePermissionGroup($id, $input);
        
        return redirect()->route('admin.permission_groups.index')->with('success','Permission group updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->hasPermissionTo('Delete Permission Group')) {
            abort('401', '401');
        }

        return $this->permissionGroupRepository->delete($id);
    }
}
