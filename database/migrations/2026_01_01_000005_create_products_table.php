<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farmer_id')->constrained('farmers')->cascadeOnDelete();
            $table->string('product_name', 150);
            $table->string('commodity_type', 100);
            $table->string('category', 100);
            $table->string('variety', 100)->nullable();
            $table->text('description')->nullable();
            $table->decimal('selling_price', 10, 2);
            $table->string('unit_of_measurement', 30);
            $table->decimal('available_quantity', 10, 2);
            $table->decimal('minimum_order_quantity', 10, 2)->nullable();
            $table->date('harvest_date');
            $table->unsignedInteger('estimated_shelf_life_days')->nullable();
            $table->string('product_grade', 50)->nullable();
            $table->string('product_condition', 50)->nullable();
            $table->string('production_method', 50)->nullable();
            $table->string('size_weight_classification', 50)->nullable();
            $table->enum('status', ['active', 'out_of_stock', 'archived'])->default('active');
            $table->timestamps();

            $table->index('commodity_type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
