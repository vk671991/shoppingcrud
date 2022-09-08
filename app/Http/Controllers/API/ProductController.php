<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFormRequest;
use App\Http\Resources\ProductCategoryResource;
use App\Http\Resources\ProductResource as ProductResource;
use App\Repositories\API\Products\ProductRepository as ProductRepository;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProductRepository $products;

    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $product_list = $this->products->getProducts();
            if($product_list){
                return ProductResource::collection($product_list);
            }
            return response()->json(['status' => false ,' message' => 'Something went wrong!'],500);
        }
        catch (\Exception $e) {
            return response()->json(['status' => false ,' message' => 'Something went wrong!'],500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductFormRequest $request)
    {
        try{
            $product_data = $this->products->createProduct($request);
            if($product_data->status == true){
                return response()->json(['status' => true ,'message' => 'Product added successfully!','data' => ProductResource::make($product_data->data)],200);
            }
            return response()->json(['status' => false ,'message' => $product_data->message],500);
        }
        catch (\Exception $e) {
            return response()->json(['status' => false ,'message' => 'Something went wrong.'],500);
        }
    }

    public function show($slug)
    {
        try{
            $product_data = $this->products->getProductDetails($slug);
            if($product_data->status == true){
                return response()->json(['status' => true ,'message' => 'Product fetched successfully!','data' => ProductResource::make($product_data->data)],200);
            }
            return response()->json(['status' => false ,'message' => $product_data->message],500);
        }
        catch (\Exception $e) {
            return response()->json(['status' => false ,'message' => 'Something went wrong.'],500);
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductFormRequest $request, $slug)
    {
        try{
            $product_data = $this->products->updateProduct($request,$slug);
            if($product_data->status == true){
                return response()->json(['status' => true ,'message' => 'Product updated successfully!','data' => ProductResource::make($product_data->data)],200);
            }
            return response()->json(['status' => false ,'message' => $product_data->message],500);
        }
        catch (\Exception $e) {
            return response()->json(['status' => false ,'message' => 'Something went wrong.'],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        try{
            $product_data = $this->products->deleteProduct($slug);
            if($product_data->status == true){
                return response()->json(['status' => true ,'message' => 'Product deleted successfully!'],200);
            }
            return response()->json(['status' => false ,'message' => $product_data->message],500);
        }
        catch (\Exception $e) {
            return response()->json(['status' => false ,'message' => 'Something went wrong.'],500);
        }
    }

    public function getProductCategories()
    {
        try{
            $product_category_list = $this->products->getProductCategoryList();

            if($product_category_list->status === true){
                return response()->json(['status' => true ,'message' => 'Product Category List fetched!','data' => ProductCategoryResource::collection($product_category_list->data)],200);
            }
            return response()->json(['status' => false ,'message' => $product_category_list->message],500);
        }
        catch (\Exception $e) {
            dd($e);
            return response()->json(['status' => false ,' message' => 'Something went wrong!'],500);
        }
    }
}
