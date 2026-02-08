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
        // multas
        Schema::create('fines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('condominium_id')->constrained('condominium');
            $table->foreignId('resident_id')->constrained('resident');
            $table->foreignId('occurrence_id')->constrained('occurrence')->nullable();
            $table->decimal('amount', 15, 2); //valor da multa
            $table->date('issued_at'); //data de emissão da multa
            $table->date('due_date'); //data de vencimento da multa
            // $table->string('status')->default('pendente'); //status da multa: pendente, paga, cancelada
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fines');
    }
};
