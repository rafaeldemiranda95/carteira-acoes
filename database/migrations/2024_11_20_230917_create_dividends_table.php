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
        Schema::create('dividends', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id')->constrained()->cascadeOnDelete(); // Relacionamento com Stock
            $table->string('asset_issued');
            $table->date('payment_date');
            $table->decimal('rate', 10, 4);
            $table->string('related_to')->nullable();
            $table->date('approved_on')->nullable();
            $table->string('isin_code')->nullable();
            $table->string('label')->nullable();
            $table->date('last_date_prior')->nullable();
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dividends');
    }
};
