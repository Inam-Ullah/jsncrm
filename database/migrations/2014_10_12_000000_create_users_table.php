<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id')->nullable()->index();
            $table->unsignedBigInteger('isp_id')->nullable()->index();
            $table->unsignedBigInteger('city_id')->nullable()->index();
            $table->unsignedBigInteger('area_id')->nullable()->index();
            $table->unsignedBigInteger('subarea_id')->nullable()->index();
            $table->string('name', 100);
            $table->string('username', 100)->unique();
            $table->string('email', 250)->nullable()->index();
            $table->unsignedBigInteger('admin_id')->nullable()->index();
            $table->unsignedBigInteger('franchise_id')->nullable()->index();
            $table->unsignedBigInteger('dealer_id')->nullable()->index();
            $table->unsignedBigInteger('subdealer_id')->nullable()->index();
            $table->unsignedBigInteger('reseller_id')->nullable()->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('photo', 100)->nullable();
            $table->string('nic', 100)->nullable();
            $table->string('phone', 100)->nullable();
            $table->string('mobile', 30)->nullable();
            $table->string('whatsapp', 30)->nullable();
            $table->string('lang', 10)->default('en');
            $table->text('address')->nullable();
            $table->unsignedTinyInteger('status')->default(1)->index();
            $table->boolean('sms_status')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('last_login_at')->nullable();
            $table->dateTime('last_logout_at')->nullable();
            $table->decimal('credit_limit', 12, 2)->nullable();
            $table->decimal('percentage', 5, 2)->nullable();
            $table->unsignedBigInteger('nas_id')->nullable()->index();
            $table->boolean('resl_mac')->default(false);
            $table->boolean('resl_package')->default(false);
            $table->boolean('resl_nas')->default(false);
            $table->boolean('resl_token')->default(false);
            $table->boolean('resl_prepaid_card')->default(false);
            $table->boolean('resl_user_sms_permission')->default(false);
            $table->boolean('resl_create_user')->default(false);
            $table->boolean('resl_create_dealer')->default(false);
            $table->boolean('resl_create_subdealer')->default(false);
            $table->boolean('resl_delete_user')->default(false);
            $table->boolean('resl_delete_dealer')->default(false);
            $table->boolean('resl_delete_subdealer')->default(false);
            $table->boolean('resl_user_limitation')->default(false);
            $table->unsignedInteger('resl_user_limit')->nullable();
            $table->boolean('resl_dealer_limitation')->default(false);
            $table->unsignedInteger('resl_dealer_limit')->nullable();
            $table->boolean('resl_subdealer_limitation')->default(false);
            $table->unsignedInteger('resl_subdealer_limit')->nullable();
            $table->boolean('resl_same_settings')->default(false);
            $table->boolean('resl_allow_custom_expiry')->default(false);
            $table->boolean('resl_ip_lock')->default(false);
            $table->boolean('resl_user_net_status')->default(false);
            $table->boolean('resl_subresellers_package')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
