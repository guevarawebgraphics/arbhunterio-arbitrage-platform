<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductCategories\Repositories\ProductCategoryRepositoryInterface;
use App\Services\ProductCategories\Requests\addProductCategoryRequest;
use App\Services\ProductCategories\Requests\updateProductCategoryRequest;

class ProductCategoryController extends Controller
{

    function __construct(ProductCategoryRepositoryInterface $productCategoryRepository)
    {
        $this->productCategoryRepository = $productCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('Read Product Category')) {
            abort('401', '401');
        }

        $data = $this->productCategoryRepository->fetchProductCategories();
        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());

        if ($request->ajax()) {
            return datatables()->of($data)
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (auth()->user()->can('Update Product Category')) {
                        $html = '<a href="' . route('admin.product_categories.edit', $row->id) . '" class="btn btn-primary btn-edit">Edit</a> ';
                    }
                    if (auth()->user()->can('Delete Product Category')) {
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-delete">Delete</button>';
                    }
                return $html;
            })->toJson();
        }

        return view('admin.pages.product_categories.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (!auth()->user()->hasPermissionTo('Create Product Category')) {
            abort('401', '401');
        }

        return view('admin.pages.product_categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(addProductCategoryRequest $request)
    {
        //
        if (!auth()->user()->hasPermissionTo('Create Product Category')) {
            abort('401', '401');
        }

        $this->productCategoryRepository->addProductCategory($request->only('title'));
        return redirect()->route('admin.product_categories.index')->with('success','Product Category created successfully');
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
        if (!auth()->user()->hasPermissionTo('Update Product Category')) {
            abort('401', '401');
        }

        $product_category = $this->productCategoryRepository->get($id);

        return view('admin.pages.product_categories.edit', compact('product_category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(updateProductCategoryRequest $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('Update Product Category')) {
            abort('401', '401');
        }

        $input = $request->only(['title']);
        $product_category = $this->productCategoryRepository->updateProductCategory($id, $input);
        
        return redirect()->route('admin.product_categories.index')->with('success','Product Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->hasPermissionTo('Delete Product Category')) {
            abort('401', '401');
        }

        return $this->productCategoryRepository->delete($id);
    }
    
    /**
     * Restore the specified resource from withtrashed.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!auth()->user()->hasPermissionTo('Restore Product Category')) {
            abort('401', '401');
        }

        return $this->productCategoryRepository->restore($id);
    }
}
