<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Read-only aggregated data. No create/update/delete endpoints should be
// exposed to Farmers, Buyers, or Admins — this model is only ever written
// to by a scheduled analytics job (see App\Console\Commands).
class MarketAnalyticsSnapshot extends Model
{
    public $timestamps = false;
    protected $table = 'market_analytics_snapshots';
    protected $fillable = ['commodity_type', 'metric_type', 'period_start', 'period_end', 'value', 'computed_at'];
}
