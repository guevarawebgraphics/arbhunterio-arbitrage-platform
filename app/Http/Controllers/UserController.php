<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Pages\Repositories\PageRepositoryInterface;
use App\Services\Users\Repositories\UserRepositoryInterface;
use App\Services\Users\Requests\updateProfileRequest;
use Illuminate\Support\Arr;
use Hash;

class UserController extends Controller
{
    //

    public function __construct(PageRepositoryInterface $pageRepository, UserRepositoryInterface $userRepository)
    {
        $this->pageRepository = $pageRepository;
        $this->userRepository = $userRepository;
    }

    public function indexAccountDetails(Request $request) 
    {
        $page = $this->pageRepository->getPageBySlug('customer/dashboard');
        if (!empty($page)) {
            $seo_meta = $this->getSeoMeta($page);
        }

        return view('front.pages.dashboard.account_details', compact('page'));
    }

    public function updateAccountDetails(Request $request, $id)
    {
        $user = $this->userRepository->get($id);
        if ($user->id != auth()->user()->id) {
            abort('401', '401');
        }

        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|max:45|unique:users,email,' . $id,
            'password' => 'required_if:change_password,==,1|confirmed',
            'old_password' => 'required_if:change_password,==,1|old_password:' . auth()->user()->password,
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user->fill($input)->save();

        return redirect()
            ->route('account-details')
            ->with('success', 'Account details successfully updated.');
    }

    public function indexAddress(Request $request)
    {
        $page = $this->pageRepository->getPageBySlug('customer/dashboard');
        if (!empty($page)) {
            $seo_meta = $this->getSeoMeta($page);
        }

        return view('front.pages.dashboard.address', compact('page'));
    }

    public function updateAddress(Request $request, $id)
    {
        $user = $this->userRepository->get($id);

        if ($user->id != auth()->user()->id) {
            abort('401', '401');
        }

        /* billing and shipping*/
        $input = $request->all();
        $billing_address = $this->userRepository->updateOrCreateUserBillingAddress($user, $input);
        $shipping_address = $this->userRepository->updateOrCreateUserShippingAddress($user, $input);
        
        return redirect()
            ->route('address')
            ->with('success', 'User addresses successfully updated.');
    }
}
