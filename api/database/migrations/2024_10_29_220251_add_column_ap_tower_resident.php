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
            $table->integer('apartment_id')->nullable();
            $table->integer('tower_id')->nullable();
            // $table->foreignId('apartment_id')->constrained('apartment')->nullable();
            // $table->foreignId('tower_id')->constrained('tower')->nullable();
           
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
        });
    }
};