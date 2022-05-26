<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Contacts\Repositories\ContactRepositoryInterface;
use App\Services\Contacts\Requests\addContactRequest;

class ContactController extends Controller
{
    function __construct(ContactRepositoryInterface $contactRepository)
    {
        $this->contactRepository = $contactRepository;
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

        $contacts = $this->contactRepository->fetchContacts();

        if ($request->ajax()) {
            return datatables()->of($contacts)
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (auth()->user()->can('Read Contact')) {
                        $html = '<a href="' . route('admin.contacts.show', $row->id) . '" class="btn btn-primary btn-edit">View</a> ';
                    }
                    return $html;
            })->toJson();
        }

        return view('admin.pages.contacts.index', compact('contacts'));
    }

    public function store(addContactRequest $request) 
    {
        $input = $request->all();
        $contact = $this->contactRepository->addContact($input);
        $email_data = [
            'view' => 'email.contact',
            'type' => 'contact',
            'user' => [
                'name' => $contact->name,
                'email' => $contact->email,
            ],
            'user_data' => $contact,
            'subject' => 'Thank you for contacting us.',
            'attachments' => [],
            'is_admin' => FALSE,
        ];

        $this->contactRepository->sendEmail($email_data);

        return redirect()->to('/contact-us')->with('success', 'Thank you for contacting us! We\'ll get back to you as soon as possible.');

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

        $contact = $this->contactRepository->get($id);

        return view('admin.pages.contacts.show', compact('contact'));
    }
}
