<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_gateway_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->nullable()->constrained()->nullOnDelete();
            $table->string('reference_id', 100)->nullable()->unique();
            $table->unsignedTinyInteger('gateway_type')->nullable()->index();
            $table->decimal('amount', 14, 2)->nullable();
            $table->string('currency', 10)->nullable();
            $table->unsignedTinyInteger('method')->nullable();
            $table->mediumText('method_details')->nullable();
            $table->text('request_url')->nullable();
            $table->mediumText('request_response')->nullable();
            $table->text('request_hash')->nullable();
            $table->mediumText('attributes')->nullable();
            $table->unsignedTinyInteger('redirect_status')->nullable();
            $table->text('redirect_url')->nullable();
            $table->unsignedTinyInteger('ipn_status')->nullable();
            $table->unsignedTinyInteger('status')->nullable()->index();
            $table->unsignedTinyInteger('activation_status')->nullable();
            $table->foreignId('package_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('action_by')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedTinyInteger('action_panel_type')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_gateway_transactions');
    }
};
