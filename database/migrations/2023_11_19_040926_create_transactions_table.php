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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->index()->unique();
            $table->unsignedBigInteger('amount');
            $table->foreignId('payer_id')->constrained(table: 'users', indexName: 'transactions_customer_id')->cascadeOnDelete();
            $table->dateTime('due_on');
            $table->unsignedInteger('vat');
            $table->boolean('is_vat_inclusive');
            $table->tinyInteger('status');
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
