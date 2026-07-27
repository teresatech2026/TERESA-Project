<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advisories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins');
            $table->string('title', 200);
            $table->text('content');
            $table->string('category', 100)->nullable();
            $table->string('image_path', 255)->nullable();
            $table->date('date_published')->useCurrent();
            $table->string('prepared_by', 150);
            $table->string('position', 100);
            $table->string('area_of_responsibility', 100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advisories');
    }
};
