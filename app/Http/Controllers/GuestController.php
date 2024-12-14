<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        return view('guest.index');
    }

    public function about()
    {
        return view('guest.about');
    }

    public function rules()
    {
        return view('guest.rules');
    }

    public function resources()
    {
        return view('guest.resources');
    }
}
