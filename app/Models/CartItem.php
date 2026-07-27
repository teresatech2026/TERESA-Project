<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = ['buyer_id', 'product_id', 'quantity'];

    public function buyer()   { return $this->belongsTo(Buyer::class); }
    public function product() { return $this->belongsTo(Product::class); }
}
