<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('channel', 30)->default('whatsapp');
            $table->string('event', 100);
            $table->string('name')->nullable();
            $table->string('provider_template_name')->nullable();
            $table->string('language', 20)->default('en');
            $table->text('body')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();

            $table->index(['user_id', 'channel', 'event']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_templates');
    }
};
