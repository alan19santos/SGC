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
        Schema::create('responsible_atribuition', function (Blueprint $table) {
            $table->id();
            $table->foreignId('responsible_id')->nullable()->constrained('users');
            $table->foreignId('occurrence_id')->nullable()->constrained('occurrence');
            $table->foreignId('status_occurrence_id')->nullable()->constrained('status_occurrence');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('responsible_atribuition');
    }
};
