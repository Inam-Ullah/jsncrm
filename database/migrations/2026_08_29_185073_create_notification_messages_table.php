<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('recipient_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('notification_template_id')->nullable()->constrained('notification_templates')->nullOnDelete();
            $table->foreignId('package_id')->nullable()->constrained('packages')->nullOnDelete();
            $table->string('channel', 30)->default('whatsapp');
            $table->string('destination', 30);
            $table->text('message');
            $table->string('message_type', 100)->nullable();
            $table->string('status', 30)->default('queued');
            $table->string('provider_message_id')->nullable()->unique();
            $table->json('provider_response')->nullable();
            $table->unsignedInteger('package_duration')->nullable();
            $table->unsignedTinyInteger('package_duration_type')->nullable();
            $table->foreignId('created_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('queued_at')->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'channel', 'status']);
            $table->index(['recipient_user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_messages');
    }
};
