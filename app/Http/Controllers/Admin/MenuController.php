<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Menus\Repositories\MenuRepositoryInterface;
use App\Services\Pages\Repositories\PageRepositoryInterface;
use App\Services\Menus\Requests\addMenuRequest;

class MenuController extends Controller
{

    function __construct(MenuRepositoryInterface $menuRepository, PageRepositoryInterface $pageRepository)
    {
        $this->menuRepository = $menuRepository;
        $this->pageRepository = $pageRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('Read Menu')) {
            abort('401', '401');
        }

        $menu = $this->menuRepository->fetchMenus();
        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());

        if ($request->ajax()) {
            return datatables()->of($menu)
                ->addColumn('is_active', function ($row) {
                    return ($row->is_active == '1' ? 'Yes' : 'No');
                })
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (auth()->user()->can('Update Menu')) {
                        $html = '<a href="' . route('admin.menu.edit', $row->id) . '" class="btn btn-primary btn-edit">Edit</a> ';
                    }
                    if (auth()->user()->can('Delete Menu')) {
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-delete">Delete</button>';
                    }
                return $html;
            })->toJson();
        }

        return view('admin.pages.menu.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (!auth()->user()->hasPermissionTo('Create Menu')) {
            abort('401', '401');
        }

        $menu = $this->menuRepository->fetchMenus();
        $pages = $this->pageRepository->pluckNames();
        $ordering = $this->menuRepository->getOrderings();

        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());
        return view('admin.pages.menu.create', compact('permissions', 'pages', 'ordering'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(addMenuRequest $request)
    {
        //
        if (!auth()->user()->hasPermissionTo('Create Menu')) {
            abort('401', '401');
        }

        $input = $request->all();
        $input['page_id'] = $this->pageRepository->getIdByName($request->page_id);
        $input['is_page'] = isset($input['is_page']) ? 1 : 0;
        $input['open_in_new_tab'] = isset($input['open_in_new_tab']) ? 1 : 0;
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        $menu = $this->menuRepository->addMenu($input);

        return redirect()->route('admin.menu.index')->with('success','Menu created successfully');
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
        if (!auth()->user()->hasPermissionTo('Update Menu')) {
            abort('401', '401');
        }

        $menu = $this->menuRepository->get($id);
        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());
        $pages = $this->pageRepository->pluckNames();
        $page = $this->pageRepository->getNameById($menu->page_id);
        $ordering = $this->menuRepository->getOrderings();

        return view('admin.pages.menu.edit', compact('menu', 'permissions', 'pages', 'ordering', 'page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if (!auth()->user()->hasPermissionTo('Update Menu')) {
            abort('401', '401');
        }

        $input = $request->all();
        $input['page_id'] = $this->pageRepository->getIdByName($request->page_id);
        $input['is_page'] = isset($input['is_page']) ? 1 : 0;
        $input['open_in_new_tab'] = isset($input['open_in_new_tab']) ? 1 : 0;
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        $menu = $this->menuRepository->updateMenu($id, $input);
        
        return redirect()->route('admin.menu.index')->with('success','Menu updated successfully');
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
        if (!auth()->user()->hasPermissionTo('Delete Menu')) {
            abort('401', '401');
        }

        return $this->menuRepository->delete($id);
    }

    /**
     * Restore the specified resource from withtrashed.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!auth()->user()->hasPermissionTo('Restore Menu')) {
            abort('401', '401');
        }

        return $this->menuRepository->restore($id);
    }
}
