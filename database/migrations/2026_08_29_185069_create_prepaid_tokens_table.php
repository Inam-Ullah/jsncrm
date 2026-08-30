<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prepaid_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prepaid_card_id')->constrained('prepaid_cards')->cascadeOnDelete();
            $table->string('secret')->unique();
            $table->unsignedInteger('quantity')->default(1);
            $table->boolean('generate_pdf')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('status')->default(true);
            $table->unsignedTinyInteger('usage_status')->default(0);
            $table->foreignId('used_by_customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->dateTime('used_at')->nullable();
            $table->unsignedTinyInteger('used_for')->nullable();
            $table->decimal('used_amount', 12, 2)->default(0);
            $table->ipAddress('used_ip')->nullable();
            $table->string('serial')->unique();
            $table->foreignId('sales_person_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['prepaid_card_id', 'usage_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prepaid_tokens');
    }
};
