<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Products\Repositories\ProductRepositoryInterface;
use App\Services\ProductCategories\Repositories\ProductCategoryRepositoryInterface;
use App\Services\SeoMetas\Repositories\SeoMetasRepositoryInterface;
use App\Services\CategoryPerProducts\Repositories\CategoryPerProductRepositoryInterface;
use App\Services\Products\Requests\addProductRequest;
use App\Services\Products\Requests\updateProductRequest;

class ProductController extends Controller
{
    //
    function __construct(ProductRepositoryInterface $productRepository,
                         ProductCategoryRepositoryInterface $productCategoryRepository,
                         SeoMetasRepositoryInterface $seoMetasRepository,
                         CategoryPerProductRepositoryInterface $categoryPerProductRepository
    )
    {
        $this->productRepository = $productRepository;
        $this->productCategoryRepository = $productCategoryRepository;
        $this->seoMetasRepository = $seoMetasRepository;
        $this->categoryPerProductRepository = $categoryPerProductRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('Read Product')) {
            abort('401', '401');
        }

        $data = $this->productRepository->fetchAll();
        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());

        if ($request->ajax()) {
            return datatables()->of($data)
                ->addColumn('is_active', function ($row) {
                    return ($row->is_active == '1' ? 'Yes' : 'No');
                })
                ->addColumn('category', function ($row) {
                    return $row->perCategory->category->title;
                })
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (auth()->user()->can('Update Product')) {
                        $html = '<a href="' . route('admin.products.edit', $row->id) . '" class="btn btn-primary btn-edit">Edit</a> ';
                    }
                    if (auth()->user()->can('Delete Product')) {
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-delete">Delete</button>';
                    }
                return $html;
            })->toJson();
        }

        return view('admin.pages.products.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (!auth()->user()->hasPermissionTo('Create Product')) {
            abort('401', '401');
        }

        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());
        $categories = $this->productCategoryRepository->pluckNames();

        return view('admin.pages.products.create', compact('permissions', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(addProductRequest $request)
    {
        //
        if (!auth()->user()->hasPermissionTo('Create Product')) {
            abort('401', '401');
        }

        $input = $request->all();
        /* seo meta */
        $input['seo_meta_id'] = isset($input['seo_meta_id']) ? $input['seo_meta_id'] : 0;
        $seo_inputs = $request->only(['meta_title', 'meta_keywords', 'meta_description', 'seo_meta_id']);
        $seo_meta = $this->seoMetasRepository->updateOrCreateSeoMetas($seo_inputs);
        $input['seo_meta_id'] = $seo_meta->id;
        /* seo meta */

        $product = $this->productRepository->addProduct($input);

        $this->categoryPerProductRepository->createData([
            'product_id' => $product->id,
            'product_category_id' => $request->id,
        ]);

        if ($request->hasFile('image')) {
            $file_upload_path = $this->productRepository->uploadFile($request->file('image'), $product);
            $product->fill(['image' => $file_upload_path])->save();
        }

        if ($request->hasFile('images')) {
            $this->productRepository->galleryUploadOnCreate($product->id, $request);
        }

        return redirect()->route('admin.products.index')->with('success','Product created successfully');
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
        if (!auth()->user()->hasPermissionTo('Update Product')) {
            abort('401', '401');
        }

        $product = $this->productRepository->get($id);
        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());
        $categories = $this->productCategoryRepository->pluckNames();
        $category = $this->categoryPerProductRepository->get($id)->category->id;

        return view('admin.pages.products.edit', compact('product', 'permissions', 'categories', 'category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(updateProductRequest $request, $id)
    {
        if (!auth()->user()->hasPermissionTo('Update Product')) {
            abort('401', '401');
        }

        $input = $request->all();
        /* seo meta */
        $input['seo_meta_id'] = isset($input['seo_meta_id']) ? $input['seo_meta_id'] : 0;
        $seo_inputs = $request->only(['meta_title', 'meta_keywords', 'meta_description', 'seo_meta_id']);
        $seo_meta = $this->seoMetasRepository->updateOrCreateSeoMetas($seo_inputs);
        $input['seo_meta_id'] = $seo_meta->id;
        /* seo meta */
        $product = $this->productRepository->updateProduct($id, $input);
        $category = $this->categoryPerProductRepository->get($id)->id;

        $this->categoryPerProductRepository->updateData($category, [
            'product_id' => $id,
            'product_category_id' => $request->id,
        ]);

        if ($request->hasFile('image')) {
            $file_upload_path = $this->productRepository->uploadFile($request->file('image'), $product);
            $product->fill(['image' => $file_upload_path])->save();
        }

        if ($request->hasFile('images')) {
            $this->productRepository->galleryUploadOnCreate($product->id, $request);
        }
        
        return redirect()->route('admin.products.index')->with('success','Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!auth()->user()->hasPermissionTo('Delete Product')) {
            abort('401', '401');
        }

        return $this->productRepository->delete($id);
    }
    
    /**
     * Restore the specified resource from withtrashed.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!auth()->user()->hasPermissionTo('Restore Product')) {
            abort('401', '401');
        }

        return $this->productRepository->restore($id);
    }

    public function galleryUpload(Request $request, $id)
    {
        $isUploaded = $this->productRepository->galleryUpload($id, $request);

        if($isUploaded === FALSE)
            return redirect()->to('/admin/products/'. $id .'/edit')->with('error', 'Failed to update Project');
            
        return redirect()->to('/admin/products/'. $id .'/edit')->with('success', 'Project has been updated successfully.');
    }

    public function galleryDelete(Request $request, $id)
    {
        $isDeleted = $this->productRepository->galleryDelete($id, $request);

        if($isDeleted === FALSE)
            return redirect()->to('/admin/products/'. $id .'/edit')->with('error', 'Failed to update Project');

        return redirect()->to('/admin/products/'. $id .'/edit')->with('success', 'Project has been updated successfully.');
    }
}
