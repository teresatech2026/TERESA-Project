<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    protected $fillable = [
        'product_id', 'buyer_id', 'quantity', 'offered_price', 'message', 'status', 'order_id',
    ];

    public function product() { return $this->belongsTo(Product::class); }
    public function buyer()   { return $this->belongsTo(Buyer::class); }
    public function order()   { return $this->belongsTo(Order::class); }

    public function getOfferedTotalAttribute()
    {
        return $this->quantity * $this->offered_price;
    }
}