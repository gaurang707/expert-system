<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaravelBasicController extends Controller
{
    public function counterReset() 
    {
        return view('basic.counter_reset');
    }
}
