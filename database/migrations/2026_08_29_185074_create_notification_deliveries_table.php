<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notification_message_id')->constrained('notification_messages')->cascadeOnDelete();
            $table->string('provider_message_id')->nullable()->index();
            $table->string('status', 30);
            $table->json('provider_response')->nullable();
            $table->dateTime('received_at');
            $table->timestamps();

            $table->index(['notification_message_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_deliveries');
    }
};
