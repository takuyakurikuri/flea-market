<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_method',
        'address_id',
        'item_id'
    ];

    public function item(){
        return $this->hasOne(item::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}