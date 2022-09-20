<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        return view('shop.index');
    }

    public function create()
    {
        return view('shop.create');
    }

    public function edit($slug)
    {
        return view('shop.edit');
    }
}
