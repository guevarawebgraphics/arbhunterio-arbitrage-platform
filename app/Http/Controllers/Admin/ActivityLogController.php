<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Services\Users\Repositories\UserRepositoryInterface;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request) 
    {
        if (!auth()->user()->hasPermissionTo('Read Activity Log')) {
            abort('401', '401');
        }

        if ($request->ajax()) {
            $data = Activity::all();
            return datatables()->of($data)
                ->addColumn('name', function ($row) {
                    return $this->userRepository->get($row->causer_id)->name;
                })
                ->addColumn('log', function ($row) {
                    return $row->created_at->diffForHumans();
                })->toJson();
        }

        return view('admin.pages.activity_logs.index');
    }
}
