<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return view('backend.index');
    }

    public function create()
    {
        return view('backend.create');
    }

    public function edit($slug)
    {
        return view('backend.edit');
    }
}
