<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SportsBooks\Repositories\SportsBookRepositoryInterface;
use App\Services\SportsBooks\Requests\addSportsBookRequest;
use App\Services\SportsBooks\Requests\updateSportsBookRequest;
use App\Services\SportsBooks\SportsBook;

/**
 * Class SportsBookController
 * @package App\Http\Controllers
 * @author Richard Guevara
 */

class SportsBookController extends Controller
{

    function __construct(SportsBookRepositoryInterface $sportsBookRepository
    )
    {
        $this->sportsBookRepository = $sportsBookRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if (!auth()->user()->hasPermissionTo('Read SportsBook')) {
            abort('401', '401');
        }

        $data = $this->sportsBookRepository->fetchAll();
        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());

        if ($request->ajax()) {
            return datatables()->of($data)
                ->addColumn('is_active', function ($row) {
                    return ($row->is_active == 1 ? 'Yes' : 'No');
                })
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (auth()->user()->can('Update SportsBook')) {
                        $html = '<a href="' . route('admin.sportsbooks.edit', $row->id) . '" class="btn btn-info btn-xs m-b-5 custom_btn" data-toggle="tooltip" data-placement="left" title="" data-original-title="Update"><i class="pe-7s-note" aria-hidden="true"></i></a> ';
                    }
                    if (auth()->user()->can('Delete SportsBook')) {
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-xs m-b-5 custom_btn btn-delete" data-toggle="tooltip" data-placement="right" title="" data-original-title="Delete "><i class="pe-7s-trash" aria-hidden="true"></i></button>';
                    }
                return $html;
            })->toJson();
        }

        return view('admin.pages.sportsbook.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (!auth()->user()->hasPermissionTo('Create SportsBook')) {
            abort('401', '401');
        }
        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());

        return view('admin.pages.sportsbook.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(addSportsBookRequest $request)
    {
        //
        if (!auth()->user()->hasPermissionTo('Create SportsBook')) {
            abort('401', '401');
        }

        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        $this->sportsBookRepository->addData($input);

        return redirect()->route('admin.sportsbooks.index')->with('success','SportsBook created successfully');
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
    public function edit(SportsBook $sportsBook)
    {
        //
        if (!auth()->user()->hasPermissionTo('Update SportsBook')) {
            abort('401', '401');
        }
        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());
        
        return view('admin.pages.sportsbook.edit', compact('permissions', 'sportsBook'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updateSportsBookRequest $request, SportsBook $sportsBook)
    {
        //
        if (!auth()->user()->hasPermissionTo('Update SportsBook')) {
            abort('401', '401');
        }

        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        $this->sportsBookRepository->updateData($sportsBook->id, $input);
        
        return redirect()->route('admin.sportsbooks.index')->with('success', 'SportsBook updated successfully');
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
        if (!auth()->user()->hasPermissionTo('Delete SportsBook')) {
            abort('401', '401');
        }

        return $this->sportsBookRepository->delete($id);
    }

    /**
     * Restore the specified resource from withtrashed.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!auth()->user()->hasPermissionTo('Restore SportsBook')) {
            abort('401', '401');
        }

        return $this->sportsBookRepository->restore($id);
    }
}