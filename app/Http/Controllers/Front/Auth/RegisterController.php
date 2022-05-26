<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Http\Traits\SystemSettingTrait;
//use App\Models\Cart;
use App\Services\Users\User;
use App\Services\Pages\Repositories\PageRepositoryInterface;
use App\Services\Users\Repositories\UserRepositoryInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Services\SystemSettings\SystemSetting;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, SystemSettingTrait;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @param User $user_model
     * @param Role $role_model
     * @param PageRepositoryInterface $pageRepository
     * @param UserRepositoryInterface $userRepository
     *
     */
    public function __construct(User $user_model,
                                Role $role_model,
                                PageRepositoryInterface $pageRepository,
                                UserRepositoryInterface $userRepository
    )
    {
        /*
        * Model namespace
        * using $this->user_model can also access $this->user_model->where('id', 1)->get();
        * */
        $this->user_model = $user_model;
        $this->role_model = $role_model;
        $this->pageRepository = $pageRepository;
        $this->userRepository = $userRepository;

        $this->middleware('isFront.guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        if (SystemSetting::where('code', 'BJCDL_010')->first()->value == 0) {
            abort('404', '404');
        }
        
        $page = $this->pageRepository->getPageBySlug('user/register');
        if (!empty($page)) {
            $seo_meta = $this->getSeoMeta($page);
        }

        return view('front.auth.register', compact('page'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required',
            'user_name' => 'required|unique:users,user_name,NULL,id,deleted_at,NULL',
            'email' => 'required|unique:users,email,NULL,id,deleted_at,NULL',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        if (SystemSetting::where('code', 'BJCDL_010')->first()->value == 0) {
            abort('404', '404');
        }

        $user = $this->user_model->create([
            'name' => $data['name'],
            'user_name' => $data['user_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        /* normal role */
        $roles = [3];
        if (isset($roles)) {
            foreach ($roles as $role) {
                $role_r = $this->role_model->where('id', '=', $role)->firstOrFail();
                $user->assignRole($role_r);
            }
        }

        return $user;
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        //$check_cart = Cart::where('user_id',$user->id)->count();

        if (!in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
            $email_data = [
                'view' => 'email.registered',
                'type' => 'registered',
                'user' => [
                    'name' => $user->first_name,
                    'email' => $user->email,
                ],
                'user_data' => $user,
                'subject' => 'Registration Successful',
                'attachments' => [],
                'is_admin' => FALSE,
            ];

            /* send email to user */
            $this->userRepository->sendEmail($email_data);

            /* send email to admin */
            $email_data['is_admin'] = TRUE;
            $email_data['view'] = 'email.registered_admin';
            $email_data['subject'] = 'New Registration';
            $this->userRepository->sendEmail($email_data);
        }

        if(session()->get('redirect_checkout') == 'true')
        {
            session()->forget('redirect_checkout');
            session()->put('first_log','true');
            return redirect('checkout');
        }
        else
        {
            return $this->registered($request, $user)
                ?: redirect($this->redirectPath());
        }
    }
}
