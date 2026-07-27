<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'buyer_id', 'farmer_id', 'status', 'delivery_option',
        'delivery_address', 'total_amount',
    ];

    public function buyer()  { return $this->belongsTo(Buyer::class); }
    public function farmer() { return $this->belongsTo(Farmer::class); }
    public function items()  { return $this->hasMany(OrderItem::class); }
    public function review() { return $this->hasOne(Review::class); }
}
