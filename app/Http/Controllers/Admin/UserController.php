<?php
    
namespace App\Http\Controllers\Admin;
    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\Users\Repositories\UserRepositoryInterface;
use App\Services\Roles\Repositories\RoleRepositoryInterface;
use App\Services\Users\Requests\addUserRequest;
use App\Services\Users\Requests\updateUserRequest;
use Illuminate\Support\Arr;
use Hash;
use DB;
    
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(UserRepositoryInterface $userRepository, RoleRepositoryInterface $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('Read User')) {
            abort('401', '401');
        }

        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());
        if ($request->ajax()) {
            $data = $this->userRepository->fetchUsers(auth()->user()->id);
            return datatables()->of($data)
                ->addColumn('name', function ($row) {
                    return $row->first_name . ' ' . $row->middle_name . ' ' . $row->last_name;
                })
                ->addColumn('role', function ($row) {
                    return $row->roles()->pluck('name')->implode(', ');
                })
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (auth()->user()->can('Update User')) {
                        $html = '<a href="' . route('admin.users.edit', $row->id) . '" class="btn btn-primary btn-edit">Edit</a> ';
                    }
                    if (auth()->user()->can('Delete User')) {
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-delete">Delete</button>';
                    }
                    return $html;
                })->toJson();
        }

        return view('admin.pages.users.index', compact('permissions'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('Create User')) {
            abort('401', '401');
        }

        $roles = $this->roleRepository->pluckNames();
        return view('admin.pages.users.create',compact('roles'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(addUserRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        $user = $this->userRepository->addUser($input);
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('admin.users.index')->with('success','User created successfully');
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->hasPermissionTo('Update User')) {
            abort('401', '401');
        }

        $user = $this->userRepository->get($id);
        $roles = $this->roleRepository->pluckNames();
        $userRole = $user->roles->pluck('name','name')->all();
    
        return view('admin.pages.users.edit',compact('user','roles','userRole'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updateUserRequest $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('Update User')) {
            abort('401', '401');
        }
    
        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        if (!empty($input['password'])) { 
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input,array('password'));    
        }
        $user = $this->userRepository->updateUser($id, $input);
        DB::table('user_has_roles')->where('user_id', $id)->delete();
    
        $user->assignRole($request->input('roles'));
    
        return redirect()->route('admin.users.index')->with('success','User updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->hasPermissionTo('Delete User')) {
            abort('401', '401');
        }

        return $this->userRepository->delete($id);
    }

    /**
     * Restore the specified resource from withtrashed.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!auth()->user()->hasPermissionTo('Restore User')) {
            abort('401', '401');
        }

        return $this->userRepository->restore($id);
    }
}