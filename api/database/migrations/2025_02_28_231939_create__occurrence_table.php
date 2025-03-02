<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Rodar antes type_occurrence
     */
    public function up(): void
    {
        Schema::create('Occurrence', function (Blueprint $table) {
            $table->id();
            $table->timestamp('date_occurrence')->nullable();
            $table->text('observation')->nullable();
            $table->string('title')->nullable();
            $table->foreignId('user_id')->constrained('users')->nullable();
            $table->foreignId('type_occurrence_id')->constrained('type_occurrence')->nullable();
            $table->boolean('isResolved')->default(false);
            $table->text('resolution');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Occurrence');
    }
};
