<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('post_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // User who performed the action
            $table->string('status'); // The status after the action
            $table->text('notes')->nullable(); // Optional notes for rejection/approval
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_submissions');
    }
};
