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
            $table->foreignId('status_priority_id')->nullable()->constrained('status_priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('occurrence', function (Blueprint $table) {
            $table->dropForeign(['status_priority_id']);

        });
    }
};
