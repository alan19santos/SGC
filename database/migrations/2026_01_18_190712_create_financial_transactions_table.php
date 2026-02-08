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
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('condominium_id')->nullable()->constrained('condominium');
            $table->string('description'); //descrição da transação
            $table->decimal('amount', 15, 2); //valor da transação
            $table->date('transaction_date'); //data do pagamento
            $table->date('due_date'); //data de vencimento;
            $table->integer('paid_at')->default(0); //0 - não pago, 1 - pago
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial_transactions');
    }
};
