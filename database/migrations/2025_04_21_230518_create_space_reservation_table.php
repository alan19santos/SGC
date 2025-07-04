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
        Schema::create('space_reservation', function (Blueprint $table) {
            $table->id();
            $table->date('date_reserved')->nullable();
            $table->string('time');
            $table->string('observation');
            $table->boolean('is_validate')->default(false);
            $table->foreignId('user_id')->constrained('users')->nullable();
            $table->foreignId('type_reserved_id')->constrained('type_reserved')->nullable();
            $table->foreignId('type_occurrence_id')->constrained('type_occurrence')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('space_reservation');
    }
};
