<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Newsletters\Repositories\NewsletterRepositoryInterface;
use App\Services\Newsletters\Requests\addNewsletterRequest;

class NewsletterController extends Controller
{
    //
    function __construct(NewsletterRepositoryInterface $newsletterRepository)
    {
        $this->newsletterRepository = $newsletterRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (!auth()->user()->hasPermissionTo('Read Contact')) {
            abort('401', '401');
        }

        $newsletters = $this->newsletterRepository->fetchNewsletterSubsribers();

        if ($request->ajax()) {
            return datatables()->of($newsletters)
                ->addColumn('created_at', function ($row) {
                    return $row->created_at->format('M d, Y');
                })->toJson();
        }

        return view('admin.pages.newsletters.index', compact('newsletters'));
    }

    public function store(addNewsletterRequest $request) 
    {
        $input = $request->only(['email']);
        $contact = $this->newsletterRepository->addNewsletterSubsriber($input);

        return redirect()->to('/home')->with('success', 'Thank you for Subscribing!');

    }

    /**
     * Show the form for viewing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!auth()->user()->hasPermissionTo('Read Contact')) {
            abort('401', '401');
        }

        $newsletter = $this->newsletterRepository->get($id);

        return view('admin.pages.newsletters.show', compact('newsletter'));
    }
}
