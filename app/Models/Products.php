<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'price',
        'category_id',
        'description',
        'status',
        'image'
    ];

    public function scopeStatus($query)
    {
        return $query->where('status', 1);
    }

    public function product_category()
    {
        return $this->belongsTo(ProductCategories::class,'category_id','id');
    }
}
