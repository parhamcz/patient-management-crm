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
        Schema::create('congress_file', function (Blueprint $table) {
            $table->id();
            $table->foreignId('congress_id')->constrained('congresses')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('file_id')->constrained('files')
                ->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('congress_file');
    }
};
