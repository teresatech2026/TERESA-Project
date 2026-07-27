<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    protected $fillable = ['user_id', 'full_name', 'mobile_number', 'barangay', 'municipality', 'province'];

    public function user()      { return $this->belongsTo(User::class); }
    public function cartItems() { return $this->hasMany(CartItem::class); }
    public function orders()    { return $this->hasMany(Order::class); }
    public function reviews()   { return $this->hasMany(Review::class); }
}
