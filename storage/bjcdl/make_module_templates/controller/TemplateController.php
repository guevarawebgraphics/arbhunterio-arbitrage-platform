<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\DefaultServicePlural\Repositories\DefaultServiceRepositoryInterface;
use App\Services\DefaultServicePlural\Requests\addDefaultServiceRequest;
use App\Services\DefaultServicePlural\Requests\updateDefaultServiceRequest;
use App\Services\DefaultServicePlural\DefaultService;

/**
 * Class TemplateCamelCaseController
 * @package App\Http\Controllers
 * @author Richard Guevara
 */

class TemplateCamelCaseController extends Controller
{

    function __construct(DefaultServiceRepositoryInterface $LCFirstDefaultRepository
    )
    {
        $this->LCFirstDefaultRepository = $LCFirstDefaultRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if (!auth()->user()->hasPermissionTo('Read DefaultTemplate')) {
            abort('401', '401');
        }

        $data = $this->LCFirstDefaultRepository->fetchAll();
        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());

        if ($request->ajax()) {
            return datatables()->of($data)
                ->addColumn('is_active', function ($row) {
                    return ($row->is_active == 1 ? 'Yes' : 'No');
                })
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (auth()->user()->can('Update DefaultTemplate')) {
                        $html = '<a href="' . route('admin.template_snake_case_plural.edit', $row->id) . '" class="btn btn-info btn-xs m-b-5 custom_btn" data-toggle="tooltip" data-placement="left" title="" data-original-title="Update"><i class="pe-7s-note" aria-hidden="true"></i></a> ';
                    }
                    if (auth()->user()->can('Delete DefaultTemplate')) {
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-xs m-b-5 custom_btn btn-delete" data-toggle="tooltip" data-placement="right" title="" data-original-title="Delete "><i class="pe-7s-trash" aria-hidden="true"></i></button>';
                    }
                return $html;
            })->toJson();
        }

        return view('admin.pages.template_snake_case.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (!auth()->user()->hasPermissionTo('Create DefaultTemplate')) {
            abort('401', '401');
        }
        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());

        return view('admin.pages.template_snake_case.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(addDefaultServiceRequest $request)
    {
        //
        if (!auth()->user()->hasPermissionTo('Create DefaultTemplate')) {
            abort('401', '401');
        }

        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        $this->LCFirstDefaultRepository->addData($input);

        return redirect()->route('admin.template_snake_case_plural.index')->with('success','DefaultTemplate created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(DefaultService $LCFirstDefault)
    {
        //
        if (!auth()->user()->hasPermissionTo('Update DefaultTemplate')) {
            abort('401', '401');
        }
        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());
        
        return view('admin.pages.template_snake_case.edit', compact('permissions', 'LCFirstDefault'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updateDefaultServiceRequest $request, DefaultService $LCFirstDefault)
    {
        //
        if (!auth()->user()->hasPermissionTo('Update DefaultTemplate')) {
            abort('401', '401');
        }

        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        $this->LCFirstDefaultRepository->updateData($LCFirstDefault->id, $input);
        
        return redirect()->route('admin.template_snake_case_plural.index')->with('success', 'DefaultTemplate updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if (!auth()->user()->hasPermissionTo('Delete DefaultTemplate')) {
            abort('401', '401');
        }

        return $this->LCFirstDefaultRepository->delete($id);
    }

    /**
     * Restore the specified resource from withtrashed.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!auth()->user()->hasPermissionTo('Restore DefaultTemplate')) {
            abort('401', '401');
        }

        return $this->LCFirstDefaultRepository->restore($id);
    }
}