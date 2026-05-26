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
        Schema::table('lecturers', function (Blueprint $row) {
            $row->string('google_scholar_url')->nullable()->after('email');
            $row->string('sinta_url')->nullable()->after('google_scholar_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lecturers', function (Blueprint $row) {
            $row->dropColumn(['google_scholar_url', 'sinta_url']);
        });
    }
};
