<?php
namespace App\Repositories\API\Products;

use Illuminate\Pagination\LengthAwarePaginator;

interface ProductInterface{
    public function getProducts() : LengthAwarePaginator;
    public function getProductDetails($slug);
    public function uploadProductImage($request);
    public function createProduct($request);
    public function updateProduct($request,$slug);
    public function deleteProduct($slug);
    public function getProductCategoryList();
}
