<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Condition;
use App\Models\Item_Category;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'exhibitor_id',
        'item_image_path',
        'item_category_id',
        'condition_id',
        'product_name',
        'product_brand',
        'product_detail',
        'product_price',
        'purchase_id'
    ];

    public function exhibitor(){
        return $this->belongsTo(User::class);
    }

    public function condition(){
        return $this->belongsTo(Condition::class);
    }

    public function item_category(){
        return $this->belongsTo(ItemCategory::class);
    }

    public function comments(){
        return $this->hasMany(comment::class);
    }

    public function favorites(){
        return $this->hasMany(favorite::class);
    }
}