<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\BlogCategories\Repositories\BlogCategoryRepositoryInterface;
use App\Services\BlogCategories\Requests\addBlogCategoryRequest;
use App\Services\BlogCategories\Requests\updateBlogCategoryRequest;

class BlogCategoryController extends Controller
{
    function __construct(BlogCategoryRepositoryInterface $blogCategoryRepository)
    {
        $this->blogCategoryRepository = $blogCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if (!auth()->user()->hasPermissionTo('Read Blog Category')) {
            abort('401', '401');
        }

        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());
        if ($request->ajax()) {
            $data = $this->blogCategoryRepository->fetchBlogCategories();
            return datatables()->of($data)
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (auth()->user()->can('Update Blog Category')) {
                        $html = '<a href="' . route('admin.blog_categories.edit', $row->id) . '" class="btn btn-primary btn-edit">Edit</a> ';
                    }
                    if (auth()->user()->can('Delete Blog Category')) {
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-delete">Delete</button>';
                    }
                    return $html;
                })->toJson();
        }

        return view('admin.pages.blog_categories.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        if (!auth()->user()->hasPermissionTo('Create Blog Category')) {
            abort('401', '401');
        }

        return view('admin.pages.blog_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(addBlogCategoryRequest $request)
    {
        //
        if (!auth()->user()->hasPermissionTo('Create Blog Category')) {
            abort('401', '401');
        }

        $input = $request->all();
        $this->blogCategoryRepository->addBlogCategory($input);

        return redirect()->route('admin.blog_categories.index')->with('success','Blog Category created successfully');
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
        if (!auth()->user()->hasPermissionTo('Update Blog Category')) {
            abort('401', '401');
        }

        $blog_category = $this->blogCategoryRepository->get($id);

        return view('admin.pages.blog_categories.edit', compact('blog_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(updateBlogCategoryRequest $request, $id)
    {
        //
        if (!auth()->user()->hasPermissionTo('Update Blog Category')) {
            abort('401', '401');
        }

        $input = $request->only(['name']);
        $blog_category = $this->blogCategoryRepository->updateBlogCategory($id, $input);
        
        return redirect()->route('admin.blog_categories.index')->with('success','Blog Category updated successfully');
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
        if (!auth()->user()->hasPermissionTo('Delete Blog Category')) {
            abort('401', '401');
        }

        return $this->blogCategoryRepository->delete($id);
    }

    /**
     * Restore the specified resource from withtrashed.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!auth()->user()->hasPermissionTo('Restore Blog Category')) {
            abort('401', '401');
        }

        return $this->blogCategoryRepository->restore($id);
    }
}
