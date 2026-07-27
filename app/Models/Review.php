<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public $timestamps = false;
    protected $fillable = ['order_id', 'buyer_id', 'farmer_id', 'rating', 'comment'];

    public function order()  { return $this->belongsTo(Order::class); }
    public function buyer()  { return $this->belongsTo(Buyer::class); }
    public function farmer() { return $this->belongsTo(Farmer::class); }
}
