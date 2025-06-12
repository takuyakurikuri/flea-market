<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'image_path',
        'address_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function profile(){
    //     return $this->hasOne(profile::class);
    // }

    public function address(){
        return $this->belongsTo(address::class);
    }

    public function comments(){
        return $this->hasMany(comment::class);
    }

    public function favorites(){
        return $this->belongsToMany(Item::class, 'favorites', 'user_id', 'item_id');
    }

    public function purchases(){
        return $this->hasMany(Purchase::class);
    }

    public function purchasedItems(){
        return $this->hasManyThrough(Item::class, Purchase::class,'user_id','id','id','item_id');
    }

    public function transactionChats()
    {
        return $this->hasMany(TransactionChat::class);
    }

    public function givenReviews()
    {
        return $this->hasMany(TransactionReview::class, 'reviewer_id');
    }

    public function receivedReviews()
    {
        return $this->hasMany(TransactionReview::class, 'reviewee_id');
    }

}