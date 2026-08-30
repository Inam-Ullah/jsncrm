<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users_qt', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->unique()->constrained('customers')->cascadeOnDelete();
            $table->string('username', 64)->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users_qt');
    }
};
