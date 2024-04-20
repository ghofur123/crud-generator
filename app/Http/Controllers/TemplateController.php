<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function login()
    {
        return view('login.login');
    }
    public function dashboard()
    {
        return view('template.dashboard');
    }
}
