<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lecturers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('nip', 50)->nullable();
            $table->string('nidn', 50)->nullable();
            $table->string('position')->nullable(); // Functional Position
            $table->string('expertise')->nullable(); // Expertise Field
            $table->string('photo')->nullable();
            $table->string('email')->nullable();
            $table->string('google_scholar_url')->nullable();
            $table->string('sinta_url')->nullable();
            $table->foreignId('study_program_id')->nullable()->constrained()->nullOnDelete();
            $table->integer('order')->default(0)->index();
            $table->boolean('is_active')->default(true)->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lecturers');
    }
};
