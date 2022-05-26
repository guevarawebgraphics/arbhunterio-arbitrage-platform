<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Pages\Repositories\PageRepositoryInterface;
use App\Services\SeoMetas\Repositories\SeoMetasRepositoryInterface;
use App\Services\Pages\Requests\addPageRequest;
use App\Services\Pages\Requests\updatePageRequest;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(PageRepositoryInterface $pageRepository, SeoMetasRepositoryInterface $seoMetasRepository)
    {
        $this->pageRepository = $pageRepository;
        $this->seoMetasRepository = $seoMetasRepository;
    }

    public function index(Request $request) 
    {
        if (!auth()->user()->hasPermissionTo('Read Page')) {
            abort('401', '401');
        }

        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());
        $pages = $this->pageRepository->fetchPages();

        if ($request->ajax()) {
            return datatables()->of($pages)
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (auth()->user()->can('Update Page')) {
                        $html = '<a href="' . route('admin.pages.edit', $row->id) . '" class="btn btn-primary btn-edit">Edit</a> ';
                    }
                    if (auth()->user()->can('Delete Page')) {
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-delete">Delete</button>';
                    }
                    return $html;
                })->toJson();
        }

        return view('admin.pages.pages.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!auth()->user()->hasPermissionTo('Create Page')) {
            abort('401', '401');
        }
        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());

        return view('admin.pages.pages.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(addPageRequest $request)
    {
        if (!auth()->user()->hasPermissionTo('Create Page')) {
            abort('401', '401');
        }

        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        /* seo meta */
        $input['seo_meta_id'] = isset($input['seo_meta_id']) ? $input['seo_meta_id'] : 0;
        $seo_inputs = $request->only(['meta_title', 'meta_keywords', 'meta_description', 'seo_meta_id']);
        $seo_meta = $this->seoMetasRepository->updateOrCreateSeoMetas($seo_inputs);
        $input['seo_meta_id'] = $seo_meta->id;
        /* seo meta */

        $page = $this->pageRepository->addPage($input);
        if ($request->hasFile('banner_image')) {
            $page->attach($request->file('banner_image'));
        }

        return redirect()->route('admin.pages.index')->with('success','Page created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!auth()->user()->hasPermissionTo('Update Page')) {
            abort('401', '401');
        }

        $page = $this->pageRepository->get($id);
        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());

        return view('admin.pages.pages.edit', compact('page', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(updatePageRequest $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('Update Page')) {
            abort('401', '401');
        }

        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        
        /* seo meta */
        $input['seo_meta_id'] = isset($input['seo_meta_id']) ? $input['seo_meta_id'] : 0;
        $seo_inputs = $request->only(['meta_title', 'meta_keywords', 'meta_description', 'seo_meta_id']);
        $seo_meta = $this->seoMetasRepository->updateOrCreateSeoMetas($seo_inputs);
        $input['seo_meta_id'] = $seo_meta->id;
        /* seo meta */

        $page = $this->pageRepository->get($id);
        
        $this->pageRepository->updatePage($id, $input);
        if ($request->hasFile('banner_image')) {
            $page->attach($request->file('banner_image'));
        }

        foreach ($page->sections as $section) {
            if ($section->isAttachment) {
                $page->attach($request->file($section->alias));
            } else {
                $section->value = $request->input($section->alias);
                $section->save();
            }
        }

        return redirect()->route('admin.pages.index')->with('success','Page updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->hasPermissionTo('Delete Page')) {
            abort('401', '401');
        }
        
        return $this->pageRepository->delete($id);
    }

    /**
     * Restore the specified resource from withtrashed.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!auth()->user()->hasPermissionTo('Restore Page')) {
            abort('401', '401');
        }

        return $this->pageRepository->restore($id);
    }

    public function fetchAttachment($id) 
    {
        $attachment = Attachment::find($id);
        if ($attachment) {
            return url('/') . '/public/storage/' .$attachment->folder . '/' . $attachment->alias;
        }
    }

    /**
     * upload image ckeditor
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return string
     */
    public function ckEditorImageUpload(Request $request)
    {
        $funcNum = $request->get('CKEditorFuncNum');
        $message = $url = '';

        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            if ($file->isValid()) {
                $filename = uniqid() . time();
                $extension = $file->getClientOriginalExtension();

                $file->move(public_path() . '/uploads/ckeditor/', $filename . '.' . $extension);
                $url = asset('/public/uploads/ckeditor/' . $filename . '.' . $extension);

                /* save image path to browser list */
                $image_json = file_get_contents(public_path() . '/uploads/ckeditor/image_list.json');
                $image_data = json_decode($image_json, true);

                if (!is_array($image_data)) {
                    $image_data = [];
                }

                array_push($image_data, ["image" => $url]);
                $new_image_json = json_encode($image_data);
                file_put_contents(public_path() . '/uploads/ckeditor/image_list.json', $new_image_json);
            } else {
                $message = 'An error occured while uploading the file.';
            }
        } else {
            $message = 'No file uploaded.';
        }
        return '<script>window.parent.CKEDITOR.tools.callFunction(' . $funcNum . ', "' . $url . '", "' . $message . '")</script>';
    }

    public function upload(Request $request)
    {
        if (!$request->hasFile('image'))
            return response()->json([
                'status' => false,
                'message' => 'No file provided',
                'data' => []
            ]);

        $file = $request->file('image');

        $attachment = new Attachment();
        $attachment->alias = str_random() . '.' . $file->getClientOriginalExtension();
        $attachment->folder = 'Form';
        $attachment->mime = $file->getClientMimeType();
        $attachment->name = $file->getClientOriginalName();
        $attachment->extension = $file->getClientOriginalExtension();
        $attachment->save();

        $file->move(public_path('storage/Form'), $attachment->alias);

        return response()->json([
            'status' => true,
            'message' => 'Image successfully uploaded',
            'data' => $attachment
        ]);
    }
}