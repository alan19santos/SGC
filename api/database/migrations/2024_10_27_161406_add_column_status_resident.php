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
            $table->integer('status_id')->nullable();
            // $table->foreignId('status_id')->constrained('status');
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('resident', function (Blueprint $table) {
            $table->dropColumn('status_id');
        });
    }
};
