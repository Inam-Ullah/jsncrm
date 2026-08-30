<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('access_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('token_card_id')->constrained('token_cards')->cascadeOnDelete();
            $table->string('username', 64)->unique();
            $table->text('password');
            $table->foreignId('package_id')->constrained('packages')->restrictOnDelete();
            $table->foreignId('sales_person_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('status')->default(true);
            $table->unsignedTinyInteger('usage_status')->default(0);
            $table->unsignedBigInteger('nas_id')->nullable();
            $table->string('serial')->unique();
            $table->unsignedInteger('duration')->nullable();
            $table->unsignedTinyInteger('duration_type')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->unsignedTinyInteger('expiration_action')->nullable();
            $table->unsignedBigInteger('total_data_bytes')->default(0);
            $table->unsignedBigInteger('used_data_bytes')->default(0);
            $table->unsignedTinyInteger('data_volume_action')->nullable();
            $table->unsignedBigInteger('total_session_seconds')->default(0);
            $table->unsignedBigInteger('used_session_seconds')->default(0);
            $table->unsignedTinyInteger('session_volume_action')->nullable();
            $table->boolean('allow_multi_use')->default(false);
            $table->boolean('allow_other_nas')->default(false);
            $table->boolean('allow_multiple_mac')->default(false);
            $table->boolean('allow_multiple_ip')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->foreign('nas_id')->references('id')->on('nas')->nullOnDelete();
            $table->index(['status', 'usage_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('access_tokens');
    }
};
