<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MenuDropdowns\Repositories\MenuDropdownRepositoryInterface;
use App\Services\Menus\Repositories\MenuRepositoryInterface;
use App\Services\Pages\Repositories\PageRepositoryInterface;
use App\Services\MenuDropdowns\Requests\addMenuDropdownRequest;

class MenuDropdownController extends Controller
{
    function __construct(MenuDropdownRepositoryInterface $menuDropdownRepository,
                         MenuRepositoryInterface $menuRepository,
                         PageRepositoryInterface $pageRepository)
    {
        $this->menuDropdownRepository = $menuDropdownRepository;
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
        //
        if (!auth()->user()->hasPermissionTo('Read Menu Dropdown')) {
            abort('401', '401');
        }

        $dropdown = $this->menuDropdownRepository->fetchMenuDropdowns();
        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());

        if ($request->ajax()) {
            return datatables()->of($dropdown)
                ->addColumn('parent_menu', function ($row) {
                    return $row->menu->name;
                })
                ->addColumn('is_active', function ($row) {
                    return ($row->is_active == '1' ? 'Yes' : 'No');
                })
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (auth()->user()->can('Update Menu Dropdown')) {
                        $html = '<a href="' . route('admin.dropdown_menu.edit', $row->id) . '" class="btn btn-primary btn-edit">Edit</a> ';
                    }
                    if (auth()->user()->can('Delete Menu Dropdown')) {
                        $html .= '<button data-rowid="' . $row->id . '" class="btn btn-danger btn-delete">Delete</button>';
                    }
                return $html;
            })->toJson();
        }

        return view('admin.pages.dropdown_menu.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        if (!auth()->user()->hasPermissionTo('Create Menu Dropdown')) {
            abort('401', '401');
        }

        $menus = $this->menuRepository->pluckNames();
        $pages = $this->pageRepository->pluckNames();
        $ordering = $this->menuDropdownRepository->getOrderings();
        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());

        return view('admin.pages.dropdown_menu.create', compact('permissions', 'pages', 'ordering', 'menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if (!auth()->user()->hasPermissionTo('Create Menu Dropdown')) {
            abort('401', '401');
        }

        $input = $request->all();
        $input['menu_id'] = $this->menuRepository->getIdByName($request->menu_id);
        $input['page_id'] = $this->pageRepository->getIdByName($request->page_id);
        $input['is_page'] = isset($input['is_page']) ? 1 : 0;
        $input['open_in_new_tab'] = isset($input['open_in_new_tab']) ? 1 : 0;
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        $dropdown = $this->menuDropdownRepository->addMenuDropdown($input);

        return redirect()->route('admin.dropdown_menu.index')->with('success','Menu Dropdown created successfully');
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
        if (!auth()->user()->hasPermissionTo('Update Menu Dropdown')) {
            abort('401', '401');
        }

        $dropdown = $this->menuDropdownRepository->get($id);
        $permissions = json_encode(auth()->user()->with(['permissions', 'roles'])->where('id', auth()->user()->id)->first());
        $menus = $this->menuRepository->pluckNames();
        $menu = $this->menuRepository->getNameById($dropdown->menu_id);
        $pages = $this->pageRepository->pluckNames();
        $page = $this->pageRepository->getNameById($dropdown->page_id);
        $ordering = $this->menuDropdownRepository->getOrderings();

        return view('admin.pages.dropdown_menu.edit', compact('dropdown', 'menus', 'permissions', 'pages', 'ordering', 'page', 'menu'));
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
        if (!auth()->user()->hasPermissionTo('Update Menu Dropdown')) {
            abort('401', '401');
        }

        $input = $request->all();
        $input['menu_id'] = $this->menuRepository->getIdByName($request->menu_id);
        $input['page_id'] = $this->pageRepository->getIdByName($request->page_id);
        $input['is_page'] = isset($input['is_page']) ? 1 : 0;
        $input['open_in_new_tab'] = isset($input['open_in_new_tab']) ? 1 : 0;
        $input['is_active'] = isset($input['is_active']) ? 1 : 0;
        $dropdown = $this->menuDropdownRepository->updateMenuDropdown($id, $input);
        
        return redirect()->route('admin.dropdown_menu.index')->with('success','Menu Dropdown updated successfully');
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
        if (!auth()->user()->hasPermissionTo('Delete Menu Dropdown')) {
            abort('401', '401');
        }

        return $this->menuDropdownRepository->delete($id);
    }

    /**
     * Restore the specified resource from withtrashed.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        if (!auth()->user()->hasPermissionTo('Restore Menu Dropdown')) {
            abort('401', '401');
        }

        return $this->menuDropdownRepository->restore($id);
    }
}
