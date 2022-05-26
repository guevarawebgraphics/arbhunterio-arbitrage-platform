<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Services\Users\Repositories\UserRepositoryInterface;
use App\Services\Users\Requests\updateProfileRequest;
use App\Services\Users\Requests\updatePasswordRequest;

/**
 * Class AdminDashboardController
 * @package App\Http\Controllers
 * @author Bryan James Dela Luya
 */
class AdminDashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Admin Dashboard Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles admin dashboard.
    |
    */

    /**
     * Create a new controller instance.
     *
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.dashboard.index');
    }

    public function profile()
    {
        return view('admin.pages.profile.index');
    }

    public function profileUpdate(updateProfileRequest $request, $id) 
    {
        $input = $request->all();
        $this->userRepository->updateProfile($id, $input);
        return redirect()->route('admin.profile')->with('success','Profile updated successfully');
    }

    public function passwordUpdate(updatePasswordRequest $request, $id) 
    {
        $input = $request->all();
        $this->userRepository->updatePassword($id, $input);

        return redirect()->route('admin.profile')->with('success','Password updated successfully');
    }
}
