<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LembagaController extends Controller
{
    public function index()
    {
        return view('lembaga.index');
    }
    public function create()
    {
        return view('lembaga.create');
    }
    public function edit($id)
    {
        return view('lembaga.edit');
    }
}
