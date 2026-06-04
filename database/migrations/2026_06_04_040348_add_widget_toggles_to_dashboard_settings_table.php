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
        Schema::table('dashboard_settings', function (Blueprint $table) {
            $table->boolean('show_quick_actions')->default(true)->after('show_my_activity');
            $table->boolean('show_server_status')->default(true)->after('show_quick_actions');
            $table->boolean('show_upcoming_events')->default(true)->after('show_server_status');
            $table->boolean('show_popular_posts')->default(true)->after('show_upcoming_events');
            $table->boolean('show_todo_list')->default(true)->after('show_popular_posts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dashboard_settings', function (Blueprint $table) {
            $table->dropColumn(['show_quick_actions', 'show_server_status', 'show_upcoming_events', 'show_popular_posts', 'show_todo_list']);
        });
    }
};
