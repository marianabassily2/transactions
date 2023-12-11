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
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->index()->unique();
            $table->unsignedBigInteger('amount');
            $table->foreignUuid('transaction_id')->constrained('transactions',indexName: 'payments_transaction_id')->cascadeOnDelete();
            $table->dateTime('paid_on');
            $table->text('details')->nullable();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
