<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'description',
        'purchase_price',
        'sale_price',
        'stock',
        'category-_id',
        'brand_id',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function btand()
    {
        return $this->belongsTo(Brand::class);
    }
}
