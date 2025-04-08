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
        'user_id',
        'image_path',
        'condition',
        'name',
        'brand',
        'detail',
        'price',
    ];

    public function exhibitor(){
        return $this->belongsTo(User::class);
    }

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

    public function purchases(){
        return $this->hasMany(Purchase::class);
    }

    public function scopeKeywordSearch($query,$keyword){
        if(!empty($keyword)){
            $query->where('name','like','%'.$keyword.'%');
        }
    }
}