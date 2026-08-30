<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();

            $table->string('domain_url', 150)->unique();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('name');
            $table->string('slogan')->nullable();
            $table->string('mobile', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('currency', 10)->default('PKR');
            $table->decimal('vat', 8, 2)->default(0);
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('zip', 20)->nullable();
            $table->string('location')->nullable();
            $table->string('copyright')->nullable();
            $table->boolean('jsntext')->default(true);
            $table->string('timezone', 50)->default('Asia/Karachi');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->text('map_access_token')->nullable();

            $table->boolean('email_enabled')->default(false);
            $table->string('mail_mailer', 30)->default('smtp');
            $table->string('mail_host')->nullable();
            $table->unsignedSmallInteger('mail_port')->nullable();
            $table->string('mail_username')->nullable();
            $table->text('mail_password')->nullable();
            $table->string('mail_encryption', 20)->nullable();
            $table->string('mail_from_address')->nullable();
            $table->string('mail_from_name')->nullable();

            $table->boolean('whatsapp_enabled')->default(false);
            $table->string('whatsapp_provider', 50)->default('meta_cloud_api');
            $table->string('whatsapp_phone_number_id')->nullable();
            $table->string('whatsapp_business_account_id')->nullable();
            $table->text('whatsapp_access_token')->nullable();
            $table->text('whatsapp_webhook_verify_token')->nullable();
            $table->text('whatsapp_app_secret')->nullable();
            $table->string('whatsapp_default_language', 20)->default('en');

            $table->boolean('jazzcash_enabled')->default(false);
            $table->boolean('jazzcash_sandbox')->default(true);
            $table->string('jazzcash_merchant_id')->nullable();
            $table->string('jazzcash_submerchant_id')->nullable();
            $table->text('jazzcash_merchant_password')->nullable();
            $table->text('jazzcash_integrity_salt')->nullable();

            $table->boolean('easypaisa_enabled')->default(false);
            $table->boolean('easypaisa_sandbox')->default(true);
            $table->string('easypaisa_store_id')->nullable();
            $table->text('easypaisa_hash_key')->nullable();

            $table->boolean('nayapay_enabled')->default(false);
            $table->boolean('nayapay_sandbox')->default(true);
            $table->string('nayapay_merchant_id')->nullable();
            $table->text('nayapay_api_key')->nullable();
            $table->text('nayapay_secret_key')->nullable();

            $table->unsignedTinyInteger('page_load_style')->default(1);
            $table->unsignedTinyInteger('activation_type')->default(1);
            $table->unsignedTinyInteger('billing_system')->default(1);
            $table->unsignedTinyInteger('reseller_package_set')->default(1);
            $table->boolean('captcha_enabled')->default(false);
            $table->string('captcha_site_key')->nullable();
            $table->text('captcha_secret_key')->nullable();
            $table->boolean('usage_graph_enabled')->default(true);
            $table->boolean('dashboard_map_enabled')->default(false);
            $table->boolean('user_profile_map_enabled')->default(false);
            $table->boolean('quick_search_enabled')->default(true);

            $table->boolean('random_username')->default(false);
            $table->unsignedTinyInteger('random_username_length')->nullable();
            $table->boolean('random_password')->default(false);
            $table->unsignedTinyInteger('random_password_length')->nullable();
            $table->boolean('username_prefix_enabled')->default(false);
            $table->string('prefix_characters', 30)->nullable();
            $table->boolean('auto_renew')->default(false);
            $table->boolean('auto_payment')->default(false);
            $table->unsignedTinyInteger('leftover_days')->default(1);
            $table->boolean('allow_user_self_registration')->default(false);
            $table->boolean('allow_user_own_update')->default(true);
            $table->boolean('allow_duplicate_nic')->default(false);
            $table->boolean('allow_duplicate_phone')->default(false);
            $table->boolean('allow_duplicate_email')->default(false);
            $table->boolean('allow_all_packages')->default(false);
            $table->boolean('user_can_see_volume')->default(true);
            $table->boolean('user_profile_document_view')->default(true);
            $table->boolean('hide_user_password')->default(false);
            $table->boolean('user_reset_password')->default(false);

            $table->boolean('nas_visibility')->default(true);
            $table->unsignedTinyInteger('connection_type')->default(1);
            $table->boolean('radius_pppoe_enabled')->default(true);
            $table->boolean('radius_hotspot_enabled')->default(false);
            $table->boolean('api_pppoe_enabled')->default(false);
            $table->boolean('api_hotspot_enabled')->default(false);
            $table->boolean('api_static_ip_enabled')->default(false);
            $table->boolean('allow_any_nas')->default(true);
            $table->boolean('radius_stale_session')->default(false);
            $table->boolean('router_stale_session')->default(false);
            $table->unsignedTinyInteger('disconnect_type')->default(1);
            $table->boolean('mac_lock_all')->default(false);
            $table->boolean('remove_mac_lock_all')->default(false);
            $table->boolean('restrict_user_connection')->default(false);

            $table->boolean('otp_enabled')->default(false);
            $table->boolean('login_otp')->default(false);
            $table->boolean('password_otp')->default(false);
            $table->boolean('mobile_otp')->default(false);
            $table->unsignedTinyInteger('login_theme')->default(1);
            $table->unsignedTinyInteger('dashboard_theme')->default(0);

            $table->boolean('api_enabled')->default(false);
            $table->boolean('api_whitelist_enabled')->default(false);
            $table->text('api_whitelist_ips')->nullable();
            $table->string('api_username')->nullable();
            $table->text('api_password')->nullable();
            $table->boolean('auto_clear_logs')->default(true);
            $table->unsignedSmallInteger('memory_limit')->default(128);

            $table->boolean('grace_period_enabled')->default(false);
            $table->unsignedSmallInteger('grace_period_preset')->default(7);
            $table->unsignedTinyInteger('grace_period_preset_type')->default(1);
            $table->unsignedSmallInteger('grace_period_duration')->default(7);
            $table->unsignedTinyInteger('grace_period_duration_type')->default(2);
            $table->unsignedTinyInteger('fixed_expire_day')->nullable();
            $table->time('fixed_expire_time')->default('23:59:59');
            $table->boolean('fixed_expire_day_enabled')->default(false);
            $table->boolean('fixed_expire_time_enabled')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
