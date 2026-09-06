<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Product extends Model
{
    protected $fillable = [
        'farmer_id', 'product_name', 'commodity_type', 'category', 'variety',
        'description', 'selling_price', 'unit_of_measurement', 'available_quantity',
        'minimum_order_quantity', 'harvest_date', 'estimated_shelf_life_days',
        'product_grade', 'product_condition', 'production_method',
        'size_weight_classification', 'status',
    ];

    protected $casts = ['harvest_date' => 'date'];

    public function farmer()   { return $this->belongsTo(Farmer::class); }
    public function images()   { return $this->hasMany(ProductImage::class); }
    public function primaryImage() { return $this->hasOne(ProductImage::class)->where('is_primary', true); }
    public function orderItems() { return $this->hasMany(OrderItem::class); }
    public function bids() { return $this->hasMany(Bid::class); }

    // Freshness Status is computed, not stored.
    public function getFreshnessStatusAttribute(): string
    {
        if (!$this->estimated_shelf_life_days) {
            return 'Unknown';
        }
        $expiry = $this->harvest_date->copy()->addDays($this->estimated_shelf_life_days);
        $daysLeft = now()->diffInDays($expiry, false);

        return match (true) {
            $daysLeft < 0   => 'Expired',
            $daysLeft <= 1  => 'Use Soon',
            $daysLeft <= 3  => 'Fresh',
            default         => 'Very Fresh',
        };
    }

    /**
     * Reduce stock and automatically mark the product out_of_stock
     * once quantity reaches zero, so it disappears from the buyer
     * marketplace (which only shows status = active).
     */
    public function decrementStock(float $quantity): void
    {
        $this->decrement('available_quantity', $quantity);
        $this->refresh();

        if ($this->available_quantity <= 0 && $this->status === 'active') {
            $this->update(['status' => 'out_of_stock']);
        }
    }
}