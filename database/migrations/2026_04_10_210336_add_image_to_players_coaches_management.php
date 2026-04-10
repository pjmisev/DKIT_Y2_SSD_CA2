<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->string('image')->nullable()->after('notes');
        });

        Schema::table('coaches', function (Blueprint $table) {
            $table->string('image')->nullable()->after('notes');
        });

        Schema::table('management', function (Blueprint $table) {
            $table->string('image')->nullable()->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('players', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        Schema::table('coaches', function (Blueprint $table) {
            $table->dropColumn('image');
        });

        Schema::table('management', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
