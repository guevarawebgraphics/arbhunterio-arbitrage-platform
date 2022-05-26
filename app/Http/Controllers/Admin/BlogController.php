<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Blogs\Repositories\BlogRepositoryInterface;
use App\Services\BlogCategories\Repositories\BlogCategoryRepositoryInterface;
use App\Services\Pages\Repositories\PageRepositoryInterface;
use App\Services\SeoMetas\Repositories\SeoMetasRepositoryInterface;
use App\Services\Blogs\Requests\addBlogRequest;
use App\Services\Blogs\Requests\updateBlogRequest;

class BlogController extends Controller
{
    function __construct(BlogRepositoryInterface $blogRepository,
                        BlogCategoryRepositoryInterface $blogCategoryRepository,
                        PageRepositoryInterface $pageRepository,
                        SeoMetasRepositoryInterface $seoMetasRepository)
    {
        $this->blogCategoryRepository = $blogCategoryRepository;
        $this->blogRepository = $blogRepository;
        $this->pageRepository = $pageRepository;
        $this->seoMetasRepository = $seoMetasRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if (!auth()->user()->hasPermissionTo('Read Blog')) {
            abort('401', '401');
        }

        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());
        if ($request->ajax()) {
            $data = $this->blogRepository->fetchBlogs();
            return datatables()->of($data)
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('M d, Y');
                })
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (auth()->user()->can('Update Blog')) {
                        $html = '<a href="' . route('admin.blogs.edit', $row->id) . '" class="btn btn-primary btn-edit">Edit</a> ';
                    }
                    if (auth()->user()->can('Delete Blog')) {
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-delete">Delete</button>';
                    }
                    return $html;
                })->toJson();
        }

        return view('admin.pages.blogs.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (!auth()->user()->hasPermissionTo('Create Blog')) {
            abort('401', '401');
        }

        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());
        $blog_categories = $this->blogCategoryRepository->pluckNames();
        return view('admin.pages.blogs.create', compact('blog_categories', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(addBlogRequest $request)
    {
        //
        if (!auth()->user()->hasPermissionTo('Create Blog')) {
            abort('401', '401');
        }

        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        $input['is_featured'] = isset($input['is_featured']) ? 1 : 0;
        /* seo meta */
        $input['seo_meta_id'] = isset($input['seo_meta_id']) ? $input['seo_meta_id'] : 0;
        $seo_inputs = $request->only(['meta_title', 'meta_keywords', 'meta_description', 'seo_meta_id']);
        $seo_meta = $this->seoMetasRepository->updateOrCreateSeoMetas($seo_inputs);
        $input['seo_meta_id'] = $seo_meta->id;
        /* seo meta */
        $blog = $this->blogRepository->addBlog($input);

        if ($request->hasFile('thumbnail')) {
            $file_upload_path = $this->blogRepository->uploadFile($request->file('thumbnail'), $blog);
            $blog->fill(['thumbnail' => $file_upload_path])->save();
        }
        if ($request->hasFile('cover_image')) {
            $file_upload_path = $this->blogRepository->uploadFile($request->file('cover_image'), $blog);
            $blog->fill(['cover_image' => $file_upload_path])->save();
        }

        return redirect()->route('admin.blogs.index')->with('success','Blog created successfully');
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
        if (!auth()->user()->hasPermissionTo('Update Blog')) {
            abort('401', '401');
        }

        $blog = $this->blogRepository->get($id);
        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());
        $blog_categories = $this->blogCategoryRepository->pluckNames();

        return view('admin.pages.blogs.edit', compact('blog', 'permissions', 'blog_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updateBlogRequest $request, $id)
    {
        //
        if (!auth()->user()->hasPermissionTo('Update Blog')) {
            abort('401', '401');
        }

        $input = $request->all();
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        $input['is_featured'] = isset($input['is_featured']) ? 1 : 0;
        /* seo meta */
        $input['seo_meta_id'] = isset($input['seo_meta_id']) ? $input['seo_meta_id'] : 0;
        $seo_inputs = $request->only(['meta_title', 'meta_keywords', 'meta_description', 'seo_meta_id']);
        $seo_meta = $this->seoMetasRepository->updateOrCreateSeoMetas($seo_inputs);
        $input['seo_meta_id'] = $seo_meta->id;
        /* seo meta */
        $blog = $this->blogRepository->updateBlog($id, $input, $request);
        
        return redirect()->route('admin.blogs.index')->with('success','Blog updated successfully');
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
        if (!auth()->user()->hasPermissionTo('Delete Blog')) {
            abort('401', '401');
        }

        return $this->blogRepository->delete($id);
    }

    /**
     * Restore the specified resource from withtrashed.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!auth()->user()->hasPermissionTo('Restore Blog')) {
            abort('401', '401');
        }

        return $this->blogRepository->restore($id);
    }

    // must be moved to Controllers/Front
    public function details($slug) 
    {
        $blog = $this->blogRepository->getBySlug($slug);

        return view('front.pages.dynamic.details.blog-view', compact('blog'));
    }

    public function categories($category) 
    {
        $page = $this->pageRepository->getPageBySlug('blogs');
        $filtered = $this->blogCategoryRepository->getByName($category);
        $blogs = $this->blogRepository->getByCategory($filtered->id);
        return view('front.pages.dynamic.blogs', compact('page', 'blogs'));
    }
}
