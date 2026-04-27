<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add team_id to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('team_id')->nullable()->after('status')->constrained('teams')->nullOnDelete();
        });

        // Add team_id to profiles table (replacing the string 'team' column)
        Schema::table('profiles', function (Blueprint $table) {
            $table->foreignId('team_id')->nullable()->after('profileable_id')->constrained('teams')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropColumn('team_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropColumn('team_id');
        });
    }
};
