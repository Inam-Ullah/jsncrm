<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('otps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('mobile', 30)->nullable()->index();
            $table->text('message')->nullable();
            $table->string('code')->index();
            $table->boolean('verified')->default(false);
            $table->string('action_type')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->dateTime('verified_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'action_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('otps');
    }
};
