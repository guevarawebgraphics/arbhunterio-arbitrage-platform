<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Controllers\Controller;
use App\Services\Pages\Repositories\PageRepositoryInterface;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Http\Traits\SystemSettingTrait;

/**
 * Class ForgotPasswordController
 * @package App\Http\Controllers\Auth
 */
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails, SystemSettingTrait;

    /**
     * Create a new controller instance.
     *
     * @param PageRepositoryInterface $pageRepository
     *
     */
    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
        $this->middleware('isFront.guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        $page = $this->pageRepository->getPageBySlug('user/password/email');
        if (!empty($page)) {
            $seo_meta = $this->getSeoMeta($page);
        }

        return view('front.auth.passwords.email', compact('page'));
    }
}
