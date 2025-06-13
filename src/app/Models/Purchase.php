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
        'item_id',
        'status',
    ];

    public function item(){
        return $this->belongsTo(item::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function chats()
    {
        return $this->hasMany(TransactionChat::class);
    }

    public function reviews()
    {
        return $this->hasMany(TransactionReview::class);
    }

}