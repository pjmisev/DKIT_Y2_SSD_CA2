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
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedTinyInteger('age')->nullable();
            $table->string('position')->nullable();
            $table->string('team')->nullable();
            $table->unsignedTinyInteger('jersey_number')->nullable();
            $table->string('nationality')->nullable();
            $table->string('dominant_hand', 10)->nullable(); 
            $table->unsignedSmallInteger('height_cm')->nullable();
            $table->unsignedSmallInteger('weight_kg')->nullable();
            $table->string('health_status', 20)->default('fit');
            $table->date('date_of_birth')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('players');
    }
};