<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Repositories\API\Products\ProductRepository as ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        return view('frontend.index');
    }
}
