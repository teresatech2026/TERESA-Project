<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('buyers');
            $table->foreignId('farmer_id')->constrained('farmers');
            $table->enum('status', [
                'pending', 'confirmed', 'preparing',
                'ready_for_pickup', 'out_for_delivery',
                'completed', 'cancelled',
            ])->default('pending');
            $table->enum('delivery_option', ['pickup', 'delivery'])->nullable();
            $table->text('delivery_address')->nullable();
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->timestamps();

            $table->index('buyer_id');
            $table->index('farmer_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
