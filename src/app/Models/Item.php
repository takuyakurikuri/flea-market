<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Condition;
use App\Models\Product_Category;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'exhibitor_id',
        'product_image_path',
        'product_category_id',
        'condition_id',
        'product_name',
        'product_brand',
        'product_detail',
        'product_price'
    ];

    public function exhibitor(){
        return $this->belongsTo(User::class);
    }

    public function condition(){
        return $this->belongsTo(Condition::class);
    }

    public function product_category(){
        return $this->belongsTo(ProductCategory::class);
    }
}