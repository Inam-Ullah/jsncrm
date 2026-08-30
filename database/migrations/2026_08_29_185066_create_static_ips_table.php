<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('static_ips', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('ip_address')->unique();
            $table->foreignId('customer_id')->nullable()->unique()->constrained('customers')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('static_ips');
    }
};
