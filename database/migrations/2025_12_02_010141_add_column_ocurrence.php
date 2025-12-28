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
        Schema::table('occurrence', function (Blueprint $table) {
            // $table->timestamps();
            $table->integer('previsibles_days')->nullable();
            $table->foreignId('resident_id')->nullable()->constrained('resident');
            $table->foreignId('condominium_id')->nullable()->constrained('condominium');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('occurrence', function (Blueprint $table) {
            $table->dropColumns(['previsibles_days']);
            $table->dropColumns(['resident_id']);
            $table->dropColumns(['condominium_id']);
        });
    }
};
