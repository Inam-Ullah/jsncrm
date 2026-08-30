<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('username', 100)->index();
            $table->foreignId('package_id')->nullable()->constrained('packages')->nullOnDelete();
            $table->foreignId('sales_person_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('discount', 10, 2)->default(0);
            $table->boolean('is_enabled')->default(false);
            $table->boolean('is_quota_expired')->default(false);
            $table->unsignedBigInteger('quota_total')->default(0);
            $table->unsignedBigInteger('quota_used')->default(0);
            $table->decimal('quota_session', 12, 2)->default(0);
            $table->decimal('quota_total_session', 12, 2)->default(0);
            $table->unsignedTinyInteger('connection_type')->nullable();
            $table->boolean('connection_status')->default(true);
            $table->boolean('mac_lock')->default(true);
            $table->unsignedInteger('macs')->default(0);
            $table->string('static_ip', 50)->nullable();
            $table->string('static_ip_netmask')->nullable();
            $table->string('mac_address', 50)->nullable();
            $table->string('box_number', 50)->nullable();
            $table->string('box_address', 50)->nullable();
            $table->string('uplink_port', 50)->nullable();
            $table->string('fiber_code', 50)->nullable();
            $table->string('fiber_color', 50)->nullable();
            $table->string('switch_board', 50)->nullable();
            $table->string('switch_port', 50)->nullable();
            $table->string('backup_connection', 50)->nullable();
            $table->string('electricity_socket', 50)->nullable();
            $table->string('cable_type', 50)->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('timezone', 50)->nullable();
            $table->dateTime('activation_date')->nullable();
            $table->foreignId('activation_by')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('renew_date')->nullable();
            $table->dateTime('last_login_time')->nullable();
            $table->dateTime('last_logout_time')->nullable();
            $table->dateTime('last_expiration_date')->nullable();
            $table->dateTime('current_expiration_date')->nullable();
            $table->dateTime('last_profile_visit_time')->nullable();
            $table->dateTime('last_interim_update')->nullable();
            $table->text('global_note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
