<?php

use App\Enums\ScheduleType;
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
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('robot_id')->constrained()->cascadeOnDelete();
            $table->enum('type', array_column(ScheduleType::cases(), 'value'));
            $table->date('day');
            $table->integer('slot');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
