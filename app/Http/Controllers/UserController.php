<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function about()
    {
        return view('user.about');
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function favorites()
    {
        return view('user.favorites');
    }
}
