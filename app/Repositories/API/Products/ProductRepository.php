<?php
namespace App\Repositories\API\Products;

use App\Models\ProductCategories;
use App\Models\Products;
use App\Repositories\API\Products\ProductInterface as ProductInterface;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class ProductRepository implements ProductInterface
{
    public $products;
    public $product_categories;

    function __construct(Products $products, ProductCategories $product_categories) {
        $this->products = $products;
        $this->product_categories = $product_categories;
    }

    public function getProducts() : LengthAwarePaginator
    {
        try{
            $product_list=$this->products::paginate(12);
            if($product_list->total() > 0){
                return $product_list;
            }
            return (object) [
                'status' => false,
                'message' => 'Products not found'
            ];
        }
        catch (\Exception $e) {
            return false;
        }
    }

    public function uploadProductImage($request)
    {
        try{
            $fileName = time().'.'.$request->file->extension();
            $request->file->move(public_path('uploads'), $fileName);
            return $fileName;
        }
        catch (\Exception $e) {
            return false;
        }
    }

    public function createProduct($request)
    {
        try{

            $check_category=$this->product_categories::find($request->category);

            if($check_category){
                $image_name=$this->uploadProductImage($request);

                if(!$image_name){
                    return (object) [
                        'status' => false,
                        'message' => 'Unable to upload product image'
                    ];
                }
                $product_details = $this->products::create([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'category_id' => $request->category,
                    'price' => $request->price,
                    'description' => $request->description,
                    'image' => $image_name,
                ]);
                return (object) [
                    'status' => true,
                    'data' => $product_details
                ];
            }
            return (object) [
                'status' => false,
                'message' => 'Category not found'
            ];

        }
        catch (\Exception $e) {
            return (object) [
                'status' => false,
                'message' => 'Something went wrong!'
            ];
        }
    }

    public function updateProduct($request,$slug)
    {
        try{
            $check_product =$this->products::where('slug',$slug)->first();
            $check_category=$this->product_categories::find($request->category);
            if($check_product){
                if($check_category){
                    $image_name=$this->uploadProductImage($request);

                    if(!$image_name){
                        return (object) [
                            'status' => false,
                            'message' => 'Unable to upload product image'
                        ];
                    }
                    $check_product->name = $request->name;
                    $check_product->slug=Str::slug($request->name);
                    $check_product->category_id=$request->category;
                    $check_product->price=$request->price;
                    $check_product->description=$request->description;
                    $check_product->image=$image_name;
                    $check_product->save();
                    return (object) [
                        'status' => true,
                        'data' => $check_product
                    ];
                }
                return (object) [
                    'status' => false,
                    'message' => 'Category not found'
                ];
            }
            return (object) [
                'status' => false,
                'message' => 'Product not found'
            ];

        }
        catch (\Exception $e) {
            dd($e);
            return (object) [
                'status' => false,
                'message' => 'Something went wrong!'
            ];
        }
    }

    public function deleteProduct($slug)
    {
        try{
            $check_product =$this->products::where('slug',$slug)->first();
            if($check_product){
                $check_product->delete();
                return (object) [
                    'status' => true
                ];
            }
            return (object) [
                'status' => false,
                'message' => 'Product not found'
            ];

        }
        catch (\Exception $e) {
            dd($e);
            return (object) [
                'status' => false,
                'message' => 'Something went wrong!'
            ];
        }
    }

    public function getProductCategoryList()
    {
        try{
            $product_categories = $this->product_categories::status()->get();
            if($product_categories){
                return (object) [
                    'status' => true,
                    'data' => $product_categories,
                ];
            }
            return (object) [
                'status' => false,
                'message' => 'Categories not found'
            ];
        }
        catch (\Exception $e) {
            return (object) [
                'status' => false,
                'message' => 'Something went wrong!'
            ];
        }
    }

    public function getProductDetails($slug)
    {
        try{
            $check_product =$this->products::where('slug',$slug)->first();
            if($check_product){
                return (object) [
                    'status' => true,
                    'data' => $check_product,
                ];
            }
            return (object) [
                'status' => false,
                'message' => 'Product not found'
            ];

        }
        catch (\Exception $e) {
            return (object) [
                'status' => false,
                'message' => 'Something went wrong!'
            ];
        }
    }

}
