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
        Schema::table('stocks', function (Blueprint $table) {
            $table->float('close')->nullable()->after('currency'); // Preço de fechamento
            $table->string('sector')->nullable()->after('close'); // Setor
            $table->float('market_cap')->nullable()->after('sector'); // Capitalização de mercado
            $table->text('description')->nullable()->after('market_cap'); // Descrição
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropColumn(['close', 'sector', 'market_cap', 'description']);
        });
    }
};
