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
        Schema::create('modules', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('chassis', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('propulsions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('wheels', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('steering_wheels', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('chairs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
        Schema::dropIfExists('chassis');
        Schema::dropIfExists('propulsions');
        Schema::dropIfExists('wheels');
        Schema::dropIfExists('steering_wheels');
        Schema::dropIfExists('chairs');
    }
};
