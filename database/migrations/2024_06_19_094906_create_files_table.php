<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('case_number')->nullable();
            $table->dateTime('visit_date');
            $table->string('patient_accompany')->nullable();
            $table->string('medical_history')->nullable();
            $table->string('before_operation')->nullable();
            $table->string('during_operation')->nullable();
            $table->string('after_operation')->nullable();
            $table->string('disease_comparison')->nullable();
            $table->boolean('special_case')->default(false);
            $table->foreignId('patient_id')->constrained('patients')
                ->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
