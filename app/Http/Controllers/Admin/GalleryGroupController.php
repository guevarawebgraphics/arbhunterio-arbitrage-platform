<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GalleryGroups\Repositories\GalleryGroupRepositoryInterface;
use App\Services\GalleryGroups\Requests\addGalleryGroupRequest;
use App\Services\GalleryGroups\Requests\updateGalleryGroupRequest;

class GalleryGroupController extends Controller
{
    function __construct(GalleryGroupRepositoryInterface $galleryGroupRepository)
    {
        $this->galleryGroupRepository = $galleryGroupRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if (!auth()->user()->hasPermissionTo('Read Gallery Group')) {
            abort('401', '401');
        }

        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());
        if ($request->ajax()) {
            $data = $this->galleryGroupRepository->fetchGalleryGroup();
            return datatables()->of($data)
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (auth()->user()->can('Update Gallery Group')) {
                        $html = '<a href="' . route('admin.gallery_groups.edit', $row->id) . '" class="btn btn-primary btn-edit">Edit</a> ';
                    }
                    if (auth()->user()->can('Delete Gallery Group')) {
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-delete">Delete</button>';
                    }
                    return $html;
                })->toJson();
        }

        return view('admin.pages.gallery_groups.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (!auth()->user()->hasPermissionTo('Create Gallery Group')) {
            abort('401', '401');
        }

        return view('admin.pages.gallery_groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(addGalleryGroupRequest $request)
    {
        //
        if (!auth()->user()->hasPermissionTo('Create Gallery Group')) {
            abort('401', '401');
        }

        $input = $request->all();
        $this->galleryGroupRepository->addGalleryGroup($input);

        return redirect()->route('admin.gallery_groups.index')->with('success','Gallery group created successfully');
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
    public function edit($id)
    {
        //
        if (!auth()->user()->hasPermissionTo('Update Gallery Group')) {
            abort('401', '401');
        }

        $gallery_group = $this->galleryGroupRepository->get($id);

        return view('admin.pages.gallery_groups.edit', compact('gallery_group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updateGalleryGroupRequest $request, $id)
    {
        //
        if (!auth()->user()->hasPermissionTo('Update Gallery Group')) {
            abort('401', '401');
        }

        $input = $request->only(['name']);
        $gallery_group = $this->galleryGroupRepository->updateGalleryGroup($id, $input);
        
        return redirect()->route('admin.gallery_groups.index')->with('success','Gallery group updated successfully');
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
        if (!auth()->user()->hasPermissionTo('Delete Gallery Group')) {
            abort('401', '401');
        }

        return $this->galleryGroupRepository->delete($id);
    }

    /**
     * Restore the specified resource from withtrashed.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!auth()->user()->hasPermissionTo('Restore Gallery Group')) {
            abort('401', '401');
        }

        return $this->galleryGroupRepository->restore($id);
    }
}
