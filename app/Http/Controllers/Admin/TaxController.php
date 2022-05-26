<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Countries\Repositories\CountryRepositoryInterface;
use App\Services\States\Repositories\StateRepositoryInterface;
use App\Services\States\Requests\updateStateRequest;

class TaxController extends Controller
{
    //
    function __construct(CountryRepositoryInterface $countryRepository,
                        StateRepositoryInterface $stateRepository
    )
    {
        $this->countryRepository = $countryRepository;
        $this->stateRepository = $stateRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('Read Tax')) {
            abort('401', '401');
        }

        $data = $this->stateRepository->fetchAll();
        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());

        if ($request->ajax()) {
            return datatables()->of($data)
                ->addColumn('country', function ($row) {
                    return $row->country->name;
                })
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (auth()->user()->can('Update Tax')) {
                        $html = '<a href="' . route('admin.taxes.edit', $row->id) . '" class="btn btn-primary btn-edit">Edit</a> ';
                    }
                return $html;
            })->toJson();
        }

        return view('admin.pages.taxes.index', compact('permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        if (!auth()->user()->hasPermissionTo('Update Tax')) {
            abort('401', '401');
        }

        $tax = $this->stateRepository->get($id);

        return view('admin.pages.taxes.edit', compact('tax'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(updateStateRequest $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('Update Tax')) {
            abort('401', '401');
        }

        $input = $request->all();
        $data = $this->stateRepository->updateData($id, $input);
        
        return redirect()->route('admin.taxes.index')->with('success','Taxes & Shipping updated successfully');
    }
}
