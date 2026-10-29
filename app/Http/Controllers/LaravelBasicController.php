<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LaravelBasicController extends Controller
{
    public function counterReset()
    {
        return view('basic.counter_reset');
    }

    public function namePreview(Request $request)
    {
        return view('basic.name_review');
    }

    public function namePreviewstore(Request $request)
    {
        $validatedData = $request->validate([
            'first-name' => 'required|string|alpha|min:2|max:50',
            'last-name'  => 'required|string|alpha|min:2|max:50',
        ]);
        // 2. Redirect back to the form page with the data stored in the session
        return redirect()->back()
            ->with('success', 'Form validation passed!')
            ->with('first_name', $validatedData['first-name'])
            ->with('last_name', $validatedData['last-name'])
            ->withInput(); // Keeps form inputs filled out if needed
        }

    public function bioCharacterCounter() 
    {
        return view('basic.bio_character_counter');
    }

    public function bioCharacterCounterPost(Request $request) 
    {
        $validator = Validator::validate($request->only('profile-bio'), [
            'profile-bio' => 'required|string|max:160'
        ]);

        
    }
}
