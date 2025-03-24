<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Condition;
use App\Models\CategoryItem;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'exhibitor_id',
        'item_image_path',
        //'item_category_id',
        //'condition_id',
        'condition',
        'item_name',
        'item_brand',
        'item_detail',
        'item_price',
        'purchase_id'
    ];

    public function exhibitor(){
        return $this->belongsTo(User::class);
    }

    //public function condition(){
    //    return $this->belongsTo(Condition::class);
    //}

    public function category_item(){
        return $this->hasMany(CategoryItem::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function favorites(){
        return $this->belongsToMany(User::class, 'favorites', 'item_id', 'user_id');
    }

    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }

    public function scopeKeywordSearch($query,$keyword){
        if(!empty($keyword)){
            $query->where('item_name','like','%'.$keyword.'%');
        }
    }
}