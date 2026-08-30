<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grace_periods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('action_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedInteger('preset_expiration_value')->nullable();
            $table->unsignedTinyInteger('preset_expiration_type')->nullable();
            $table->unsignedInteger('duration_value');
            $table->unsignedTinyInteger('duration_type');
            $table->unsignedTinyInteger('status')->default(1);
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->dateTime('previous_expiration_at')->nullable();
            $table->dateTime('extended_expiration_at')->nullable();
            $table->unsignedTinyInteger('billing_type')->nullable();
            $table->decimal('billing_amount', 12, 2)->default(0);
            $table->unsignedTinyInteger('billing_status')->default(0);
            $table->string('billing_info')->nullable();
            $table->timestamps();

            $table->index(['customer_id', 'status']);
            $table->index('end_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grace_periods');
    }
};
