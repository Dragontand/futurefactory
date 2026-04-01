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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('chassis_module_id')->constrained('chassis', 'module_id');
            $table->foreignId('propulsion_module_id')->constrained('propulsions', 'module_id');
            $table->foreignId('wheel_module_id')->constrained('wheels', 'module_id');
            $table->foreignId('steering_wheel_module_id')->constrained('steering_wheels', 'module_id');
            $table->foreignId('chair_module_id')->constrained('chairs', 'module_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
