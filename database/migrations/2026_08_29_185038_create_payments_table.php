<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->nullable()->constrained()->nullOnDelete();
            $table->string('transaction_id', 50)->unique();
            $table->decimal('amount', 14, 2);
            $table->unsignedTinyInteger('method')->index();
            $table->string('cheque_number')->nullable();
            $table->string('gateway_transaction_id', 100)->nullable()->index();
            $table->unsignedTinyInteger('type')->index();
            $table->foreignId('payer_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('received_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_withdrawal')->default(false);
            $table->foreignId('action_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
