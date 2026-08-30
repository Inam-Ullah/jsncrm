<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('routers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('routers')->nullOnDelete();
            $table->string('nas_ip', 100);
            $table->string('short_name', 100);
            $table->boolean('api_enabled')->default(false);
            $table->string('api_username', 100)->nullable();
            $table->text('api_password')->nullable();
            $table->dateTime('last_checked_at')->nullable();
            $table->boolean('status')->default(false);
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('routers');
    }
};
