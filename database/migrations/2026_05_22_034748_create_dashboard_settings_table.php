<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dashboard_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->constrained()->onDelete('cascade');
            $table->boolean('show_stats')->default(true);
            $table->boolean('show_announcements')->default(true);
            $table->boolean('show_recent_posts')->default(true);
            $table->boolean('show_recent_interactions')->default(true);
            $table->boolean('show_system_logs')->default(true);
            $table->boolean('show_academic_info')->default(true);
            $table->boolean('show_my_activity')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dashboard_settings');
    }
};
