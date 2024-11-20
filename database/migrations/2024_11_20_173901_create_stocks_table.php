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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('symbol')->unique(); // Ex: WEGE3, MXRF11
            $table->string('name'); // Nome completo
            $table->string('short_name')->nullable(); // Nome curto
            $table->string('type')->default('stock'); // Tipo: stock, fii, crypto
            $table->string('currency')->default('BRL'); // Moeda: BRL, USD, etc.
            $table->float('price', 10, 2)->nullable(); // Preço atual
            $table->float('change', 10, 2)->nullable(); // Variação do dia
            $table->float('change_percent', 10, 2)->nullable(); // % de variação
            $table->float('day_high', 10, 2)->nullable(); // Máxima do dia
            $table->float('day_low', 10, 2)->nullable(); // Mínima do dia
            $table->float('day_open', 10, 2)->nullable(); // Abertura
            $table->float('volume')->nullable(); // Volume negociado
            $table->float('previous_close', 10, 2)->nullable(); // Fechamento anterior
            $table->float('pe_ratio', 10, 2)->nullable(); // Price-to-Earnings (P/E)
            $table->float('eps', 10, 2)->nullable(); // Earnings per share (EPS)
            $table->string('logo_url')->nullable(); // URL do logo
            $table->string('fifty_two_week_range')->nullable(); // Faixa de 52 semanas
            $table->float('fifty_two_week_low', 10, 2)->nullable(); // Mínimo de 52 semanas
            $table->float('fifty_two_week_high', 10, 2)->nullable(); // Máximo de 52 semanas
            $table->timestamps(); // Created_at e Updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
