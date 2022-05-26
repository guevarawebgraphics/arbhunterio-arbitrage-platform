<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\GalleryImages\Repositories\GalleryImageRepositoryInterface;
use App\Services\GalleryGroups\Repositories\GalleryGroupRepositoryInterface;
use App\Services\GalleryImages\Requests\addGalleryImageRequest;
use App\Services\GalleryImages\Requests\updateGalleryImageRequest;

class GalleryImageController extends Controller
{

    function __construct(GalleryImageRepositoryInterface $galleryImageRepository,
                         GalleryGroupRepositoryInterface $galleryGroupRepository
    )
    {
        $this->galleryImageRepository = $galleryImageRepository;
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
        if (!auth()->user()->hasPermissionTo('Read Gallery Image')) {
            abort('401', '401');
        }

        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());
        if ($request->ajax()) {
            $data = $this->galleryImageRepository->fetchGalleryImages();
            return datatables()->of($data)
                ->addColumn('group', function ($row) {
                    return $row->group->name;
                })
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (auth()->user()->can('Update Gallery Image')) {
                        $html = '<a href="' . route('admin.gallery_images.edit', $row->id) . '" class="btn btn-primary btn-edit">Edit</a> ';
                    }
                    if (auth()->user()->can('Delete Gallery Image')) {
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-delete">Delete</button>';
                    }
                    return $html;
                })->toJson();
        }

        return view('admin.pages.gallery_images.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (!auth()->user()->hasPermissionTo('Create Gallery Image')) {
            abort('401', '401');
        }

        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());
        $gallery_groups = $this->galleryGroupRepository->pluckNames();
        return view('admin.pages.gallery_images.create', compact('gallery_groups', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(addGalleryImageRequest $request)
    {
        //
        if (!auth()->user()->hasPermissionTo('Create Gallery Image')) {
            abort('401', '401');
        }

        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        $gallery = $this->galleryImageRepository->addGalleryImage($input);

        if ($request->hasFile('background_image')) {
            $file_upload_path = $this->galleryImageRepository->uploadFile($request->file('background_image'), $gallery);
            $gallery->fill(['background_image' => $file_upload_path])->save();
        }

        return redirect()->route('admin.gallery_images.index')->with('success','Gallery image created successfully');
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
        if (!auth()->user()->hasPermissionTo('Update Gallery Image')) {
            abort('401', '401');
        }

        $gallery_image = $this->galleryImageRepository->get($id);
        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());
        $gallery_groups = $this->galleryGroupRepository->pluckNames();

        return view('admin.pages.gallery_images.edit', compact('gallery_image', 'permissions', 'gallery_groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updateGalleryImageRequest $request, $id)
    {
        //
        if (!auth()->user()->hasPermissionTo('Update Gallery Image')) {
            abort('401', '401');
        }

        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        $image_gallery = $this->galleryImageRepository->updateGalleryImage($id, $input, $request);
        
        return redirect()->route('admin.gallery_images.index')->with('success','Gallery image updated successfully');
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
        if (!auth()->user()->hasPermissionTo('Delete Gallery Image')) {
            abort('401', '401');
        }

        return $this->galleryImageRepository->delete($id);
    }

    /**
     * Restore the specified resource from withtrashed.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!auth()->user()->hasPermissionTo('Restore Gallery Image')) {
            abort('401', '401');
        }

        return $this->galleryImageRepository->restore($id);
    }
}
