<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('group_name', 64)->index();
            $table->string('expire_group_name', 64)->nullable()->index();
            $table->string('disable_group_name', 64)->nullable()->index();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->text('invoice_description')->nullable();
            $table->boolean('invoice_volume_status')->default(false);
            $table->unsignedInteger('duration')->default(0);
            $table->unsignedTinyInteger('duration_type')->default(30);
            $table->boolean('dynamic_bandwidth_enabled')->default(false);
            $table->boolean('session_based')->default(false);
            $table->unsignedInteger('session_time')->default(0);
            $table->unsignedInteger('session_period')->default(0);
            $table->boolean('data_quota_enabled')->default(false);
            $table->unsignedBigInteger('data_quota_volume')->nullable();
            $table->boolean('fup_enabled')->default(false);
            $table->unsignedBigInteger('fup_volume')->nullable();
            $table->string('fup_bandwidth_limit', 100)->nullable();
            $table->boolean('session_quota_enabled')->default(false);
            $table->boolean('user_self_activation')->default(false);
            $table->unsignedTinyInteger('billing_type')->default(1);
            $table->unsignedTinyInteger('extra_fee_type')->default(1);
            $table->decimal('extra_fee', 12, 2)->nullable();
            $table->unsignedTinyInteger('vat_type')->default(1);
            $table->decimal('vat', 12, 2)->nullable();
            $table->unsignedTinyInteger('fixed_expire_day')->default(0);
            $table->boolean('fixed_expire_day_enabled')->default(false);
            $table->time('fixed_expire_time')->default('23:59:59');
            $table->boolean('fixed_expire_time_enabled')->default(true);
            $table->boolean('fixed_expire_day_accounting_status')->default(false);
            $table->unsignedTinyInteger('fixed_expire_day_accounting_type')->nullable();
            $table->boolean('auto_payment')->default(false);
            $table->unsignedTinyInteger('leftover_days')->default(1);
            $table->boolean('auto_renew')->default(false);
            $table->boolean('custom_expiry_enabled')->default(false);
            $table->unsignedTinyInteger('custom_expiry_type')->default(0);
            $table->boolean('custom_expire_accounting_status')->default(false);
            $table->unsignedTinyInteger('custom_expire_accounting_type')->nullable();
            $table->boolean('left_over_volumes')->default(false);
            $table->boolean('left_over_sessions')->default(false);
            $table->boolean('data_quota_exceed_status')->default(false);
            $table->unsignedTinyInteger('data_quota_exceed_type')->default(1);
            $table->boolean('session_quota_exceed_status')->default(false);
            $table->unsignedTinyInteger('session_quota_exceed_type')->default(1);
            $table->boolean('session_fup_limit_status')->default(false);
            $table->string('session_fup_bandwidth_limit', 100)->nullable();
            $table->boolean('apply_users')->default(false);
            $table->boolean('apply_resellers')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
