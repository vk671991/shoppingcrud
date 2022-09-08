<?php

namespace Database\Seeders;

use App\Models\ProductCategories;
use Illuminate\Database\Seeder;

class ProductCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'T-Shirts','Shirts','Jeans','Formals'
        ];

        foreach ($categories as $key => $category){
            $check=ProductCategories::where('name',$category)->first();
            if(!$check){
                ProductCategories::create(['name'=>$category]);
            }
        }
    }
}
