<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('f_packages', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(0)->index();
            $table->integer('reseller_id')->nullable()->index();
            $table->integer('package_id')->default(0)->index();
            $table->decimal('cost', 12, 2)->default(0);
            $table->decimal('price', 12, 2)->nullable();
            $table->decimal('admin_profit', 12, 2)->nullable();
            $table->decimal('franchise_profit', 12, 2)->nullable();
            $table->decimal('dealer_profit', 12, 2)->nullable();
            $table->decimal('subdealer_profit', 12, 2)->nullable();
            $table->decimal('reseller_profit', 12, 2)->nullable();
            $table->decimal('customprice', 12, 2)->nullable();
            $table->integer('extra_fee_type')->nullable()->default(1);
            $table->decimal('extra_fee', 12, 2)->nullable();
            $table->integer('vat_type')->nullable()->default(1);
            $table->decimal('vat', 12, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('f_packages');
    }
};
