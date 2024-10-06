<?php

use App\Enums\GenderEnum;
use App\Enums\MaritalStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $genders = [];
        foreach (GenderEnum::cases() as $case) {
            $genders[] = ucfirst($case->value);
        }
        Schema::create('patients', function (Blueprint $table) use ($genders) {
            $table->id();
            $table->string('name')->nullable();
            $table->enum('gender', $genders)->nullable();
            $table->string('national_id', 10)->unique()->nullable();
            $table->string('phone_number')->nullable();
            $table->string('education_degree')->nullable();
            $table->string('address')->nullable();
            $table->date('first_visit_at')->nullable();
            $table->enum('marital_status', MaritalStatusEnum::values())->nullable();
            $table->tinyInteger('children_count')->default(0);
            $table->string('occupation')->nullable();
            $table->date('birthdate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
