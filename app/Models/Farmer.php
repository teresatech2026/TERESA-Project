<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    protected $fillable = [
        'user_id', 'full_name', 'sex', 'date_of_birth', 'mobile_number',
        'barangay', 'municipality', 'province',
        'overall_rating', 'total_reviews', 'completed_orders',
    ];

    public function user()     { return $this->belongsTo(User::class); }
    public function products() { return $this->hasMany(Product::class); }
    public function orders()   { return $this->hasMany(Order::class); }
    public function reviews()  { return $this->hasMany(Review::class); }

    // Commodities Offered: derived from active product listings, not stored.
    public function commoditiesOffered()
    {
        return $this->products()->where('status', 'active')->pluck('commodity_type')->unique();
    }
}
