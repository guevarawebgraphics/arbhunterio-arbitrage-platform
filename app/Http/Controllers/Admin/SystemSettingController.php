<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SystemSettings\Repositories\SystemSettingRepositoryInterface;
use App\Services\SystemSettings\Requests\addSystemSettingRequest;
use App\Services\SystemSettings\Requests\updateSystemSettingRequest;

/**
 * Class SystemSettingController
 * @package App\Http\Controllers
 * @author Guevara Web Graphics Studio
 */

class SystemSettingController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | SystemSetting Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles system settings.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @param SystemSettingRepositoryInterface $systemSettingRepository
     */
    public function __construct(SystemSettingRepositoryInterface $systemSettingRepository)
    {
        $this->systemSettingRepository = $systemSettingRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('Read System Setting')) {
            abort('401', '401');
        }

        $system_settings = $this->systemSettingRepository->fetchSettings();
        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());

        if ($request->ajax()) {
            return datatables()->of($system_settings)
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (auth()->user()->can('Update System Setting')) {
                        $html = '<a href="' . route('admin.system_settings.edit', $row->id) . '" class="btn btn-primary btn-edit">Edit</a> ';
                    }
                    if (auth()->user()->can('Delete System Setting')) {
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-delete">Delete</button>';
                    }
                    return $html;
                })->toJson();
        }

        return view('admin.pages.system_settings.index', compact('system_settings', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('Create System Setting')) {
            abort('401', '401');
        }

        $max_code = $this->systemSettingRepository->generateSystemCode('BJCDL_');

        return view('admin.pages.system_settings.create', compact('max_code'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(addSystemSettingRequest $request)
    {
        if (!auth()->user()->hasPermissionTo('Create System Setting')) {
            abort('401', '401');
        }

        $request['type'] = 'text';
        $system_setting = $this->systemSettingRepository->addSetting($request->only('code', 'name', 'value', 'type'));

        return redirect()->route('admin.system_settings.index')->with('success','System Setting created successfully');
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
        if (!auth()->user()->hasPermissionTo('Update System Setting')) {
            abort('401', '401');
        }

        $system_setting = $this->systemSettingRepository->get($id);
        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());

        return view('admin.pages.system_settings.edit', compact('system_setting', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(updateSystemSettingRequest $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('Update System Setting')) {
            abort('401', '401');
        }

        $input = $request->only(['code', 'name', 'value', 'type']);
        $this->systemSettingRepository->updateSetting($id, $input, $request);

        return redirect()->route('admin.system_settings.index')->with('success','System Setting updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->hasPermissionTo('Delete System Setting')) {
            abort('401', '401');
        }

        return $this->systemSettingRepository->delete($id);
    }

    /**
     * Restore the specified resource from withtrashed.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!auth()->user()->hasPermissionTo('Restore System Setting')) {
            abort('401', '401');
        }

        return $this->systemSettingRepository->restore($id);
    }
}
