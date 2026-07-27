<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('farmers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('full_name', 150);
            $table->enum('sex', ['Male', 'Female'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('mobile_number', 20);
            $table->string('barangay', 100);
            $table->string('municipality', 100)->default('San Jose');
            $table->string('province', 100)->default('Camarines Sur');
            $table->decimal('overall_rating', 3, 2)->default(0);
            $table->unsignedInteger('total_reviews')->default(0);
            $table->unsignedInteger('completed_orders')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('farmers');
    }
};
