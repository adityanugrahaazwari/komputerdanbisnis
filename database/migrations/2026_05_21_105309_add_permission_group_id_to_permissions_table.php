<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Add permission_group_id column
        Schema::table('permissions', function (Blueprint $table) {
            $table->foreignId('permission_group_id')->nullable()->after('group')->constrained()->nullOnDelete();
        });

        // 2. Migrate existing groups to permission_groups table
        $groups = DB::table('permissions')->whereNotNull('group')->distinct()->pluck('group');
        
        foreach ($groups as $groupName) {
            $groupId = DB::table('permission_groups')->insertGetId([
                'name' => $groupName,
                'slug' => Str::slug($groupName),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('permissions')->where('group', $groupName)->update([
                'permission_group_id' => $groupId
            ]);
        }

        // 3. Drop the old group column
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('group');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('group')->nullable()->after('name');
        });

        // Restore group string from permission_groups table
        $permissions = DB::table('permissions')->whereNotNull('permission_group_id')->get();
        foreach ($permissions as $permission) {
            $group = DB::table('permission_groups')->where('id', $permission->permission_group_id)->first();
            if ($group) {
                DB::table('permissions')->where('id', $permission->id)->update([
                    'group' => $group->name
                ]);
            }
        }

        Schema::table('permissions', function (Blueprint $table) {
            $table->dropForeign(['permission_group_id']);
            $table->dropColumn('permission_group_id');
        });
    }
};
