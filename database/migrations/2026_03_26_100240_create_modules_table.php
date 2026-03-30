<?php

use App\Enums\PropulsionType;
use App\Enums\SteeringWheelType;
use App\Enums\UpholsteryType;
use App\Enums\VehicleType;
use App\Enums\WheelType;
use App\Models\Module;
use App\Models\Modules\Chassis;
use App\Models\Modules\Wheel;
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
            $table->string('name');
            $table->decimal('price');
            $table->integer('time');
            $table->string('image');
            $table->timestamps();
        });

        Schema::create('chassis', function (Blueprint $table) {
            $table->foreignId('module_id')->primary()->constrained()->cascadeOnDelete();
            $table->enum('type', array_column(VehicleType::cases(), 'value'));
            $table->integer('amount_wheels');
            $table->integer('length');
            $table->integer('width');
            $table->integer('height');
        });

        Schema::create('propulsions', function (Blueprint $table) {
            $table->foreignId('module_id')->primary()->constrained()->cascadeOnDelete();
            $table->enum('type', array_column(PropulsionType::cases(), 'value'));
            $table->integer('horsepower');
        });

        Schema::create('wheels', function (Blueprint $table) {
            $table->foreignId('module_id')->primary()->constrained()->cascadeOnDelete();
            $table->enum('type', array_column(WheelType::cases(), 'value'));
            $table->integer('diameter');
            //$table->foreignIdFor(Chassis::class, 'compatible_chassis_id')->constrained('chassis', 'module_id')->cascadeOnDelete();
        });

        Schema::create('steering_wheels', function (Blueprint $table) {
            $table->foreignId('module_id')->primary()->constrained()->cascadeOnDelete();
            $table->enum('type', array_column(SteeringWheelType::cases(), 'value'));
            $table->string('special_request');
        });

        Schema::create('chairs', function (Blueprint $table) {
            $table->foreignId('module_id')->primary()->constrained()->cascadeOnDelete();
            $table->enum('type', array_column(UpholsteryType::cases(), 'value'));
            $table->integer('amount');
        });

        Schema::create('chassis_wheel', function (Blueprint $table) {
            $table->foreignIdFor(Chassis::class, 'chassis_module_id')
                ->constrained('chassis', 'module_id')
                ->cascadeOnDelete();
            $table->foreignIdFor(Wheel::class, 'wheel_module_id')
                ->constrained('wheels', 'module_id')
                ->cascadeOnDelete();
            $table->primary(['chassis_module_id', 'wheel_module_id']);
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
        Schema::dropIfExists('chassis_wheel');
    }
};
