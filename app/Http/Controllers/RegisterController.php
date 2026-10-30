<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('basic.register');
    }

    public function store(RegisterRequest $request)
    {
        try {
            $data = $request->validated();
            $data['password'] = Hash::make($request->password);
            User::create($data);
            return redirect()->route('register')->with('success', 'Account created successfully!');
        } catch (Exception $e) {
            logger()->error('Register user form submission failed: ' . $e->getMessage());
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Something went wrong. Please try again later.');
        }
    }

    public function passowrdPlay() 
    {
        return view('basic.password_play');
    }
}
