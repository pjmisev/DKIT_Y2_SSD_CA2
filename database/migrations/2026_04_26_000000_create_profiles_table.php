<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop old tables
        Schema::dropIfExists('players');
        Schema::dropIfExists('coaches');
        Schema::dropIfExists('management');

        // Create unified profiles table
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete()->unique();
            $table->string('profileable_type'); // App\Models\PlayerInfo, App\Models\CoachInfo, App\Models\ManagementInfo
            $table->unsignedBigInteger('profileable_id');
            $table->string('team')->nullable();
            $table->string('nationality')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('notes')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

            $table->index(['profileable_type', 'profileable_id']);
        });

        // Player-specific data
        Schema::create('player_info', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('jersey_number')->nullable();
            $table->string('position')->nullable();
            $table->string('dominant_hand', 10)->nullable();
            $table->unsignedSmallInteger('height_cm')->nullable();
            $table->unsignedSmallInteger('weight_kg')->nullable();
            $table->string('health_status', 20)->default('fit');
            $table->timestamps();
        });

        // Coach-specific data
        Schema::create('coach_info', function (Blueprint $table) {
            $table->id();
            $table->string('role')->nullable(); // Head Coach, Assistant Coach, etc.
            $table->timestamps();
        });

        // Management-specific data
        Schema::create('management_info', function (Blueprint $table) {
            $table->id();
            $table->string('role')->nullable(); // General Manager, Team Manager, etc.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
        Schema::dropIfExists('player_info');
        Schema::dropIfExists('coach_info');
        Schema::dropIfExists('management_info');

        // Recreate old tables
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('position')->nullable();
            $table->string('team')->nullable();
            $table->unsignedTinyInteger('jersey_number')->nullable();
            $table->string('nationality')->nullable();
            $table->string('dominant_hand', 10)->nullable();
            $table->unsignedSmallInteger('height_cm')->nullable();
            $table->unsignedSmallInteger('weight_kg')->nullable();
            $table->string('health_status', 20)->default('fit');
            $table->unsignedBigInteger('salary')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('linked_to')->nullable()->constrained('users')->onDelete('set null');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('coaches', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('team')->nullable();
            $table->string('role')->nullable();
            $table->string('nationality')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->unsignedBigInteger('salary')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('linked_to')->nullable()->constrained('users')->onDelete('set null');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        Schema::create('management', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('team')->nullable();
            $table->string('role')->nullable();
            $table->string('nationality')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->unsignedBigInteger('salary')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('linked_to')->nullable()->constrained('users')->onDelete('set null');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }
};
