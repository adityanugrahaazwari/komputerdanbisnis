<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->dateTime('start_date')->index();
            $table->dateTime('end_date')->nullable();
            $table->string('location')->nullable();
            $table->string('type')->default('academic')->index(); // academic, webinar, competition, holiday
            $table->string('color')->default('#dc2626'); // default red-600
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
