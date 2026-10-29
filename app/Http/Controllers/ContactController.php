<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Exception;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('basic.contact');
    }

    public function store(ContactRequest $request)
    {
        $validated = $request->validated();

        try {
            Contact::create($validated);
            return redirect()
                ->back()
                ->with('success', 'Your message has been sent successfully!');
        } catch (Exception $e) {
            logger()->error('Contact form submission failed: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Something went wrong. Please try again later.');
        }
    }
}
