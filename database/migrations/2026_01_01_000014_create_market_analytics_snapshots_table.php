<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Read-only, system-generated cache table populated by a scheduled
        // job that aggregates orders/order_items. No user (including Admin)
        // writes to this table through the UI.
        Schema::create('market_analytics_snapshots', function (Blueprint $table) {
            $table->id();
            $table->string('commodity_type', 100);
            $table->string('metric_type', 50); // demand_high, demand_low, monthly_trend, most_ordered, seasonal_trend
            $table->date('period_start');
            $table->date('period_end');
            $table->decimal('value', 12, 2);
            $table->timestamp('computed_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('market_analytics_snapshots');
    }
};
