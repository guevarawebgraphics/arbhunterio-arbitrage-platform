<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Services\Pages\Repositories\PageRepositoryInterface;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Services\Users\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Http\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\Hash;

/**
 * Class ResetPasswordController
 * @package App\Http\Controllers\Auth
 */
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords, SystemSettingTrait;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @param User $user_model
     * @param PageRepositoryInterface $page_repository
     *
     */
    public function __construct(User $user_model,
                                PageRepositoryInterface $pageRepository
    )
    {
        /*
        * Model namespace
        * using $this->user_model can also access $this->user_model->where('id', 1)->get();
        * */
        $this->user_model = $user_model;
        $this->pageRepository = $pageRepository;

        $this->middleware('isFront.guest');
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  string|null $token
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetForm(Request $request, $token = null)
    {
        $page = $this->pageRepository->getPageBySlug('user/password/reset');
        if (!empty($page)) {
            $seo_meta = $this->getSeoMeta($page);
        }

        return view('front.auth.passwords.reset', compact('page'))->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());

        $user = $this->user_model->where('email', $request->email)->first();

        if (!empty($user)) {
            if (!$user->hasAnyRole(['Normal'])) {
                return redirect()->back()
                    ->withInput($request->only('email'))
                    ->withErrors(['email' => trans('Only users with "normal" role can change their passwords')]);
            }
        }

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
            $this->resetPassword($user, $password);
        }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($response)
            : $this->sendResetFailedResponse($request, $response);
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param  string $password
     *
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->forceFill([
            'password' => Hash::make($password),
            'remember_token' => Str::random(60),
        ])->save();
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param  string $response
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetResponse($response)
    {
        return redirect($this->redirectPath())
            ->with('status', trans('Your password has been reset! Please login to continue.'));
    }
}
