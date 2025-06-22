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
        //
        Schema::table('resident', function (Blueprint $table) {

            $table->foreign('status_id')->references('id')->on('status');
             $table->foreignId('apartment_id')->constrained('apartment')->nullable();
            $table->foreignId('tower_id')->constrained('tower')->nullable();
            $table->foreignId('condominium_id')->constrained('condominium')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('resident', function (Blueprint $table) {
            $table->dropColumn('apartment_id');
            $table->dropColumn('tower_id');
            $table->dropColumn('condominium_id');
            $table->dropColumn('status_id');
        });

    }
};
