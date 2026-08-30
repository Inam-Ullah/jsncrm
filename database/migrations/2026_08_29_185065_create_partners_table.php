<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('photo')->nullable();
            $table->string('name', 100)->nullable();
            $table->string('product_name', 200)->nullable();
            $table->string('company', 200)->nullable();
            $table->text('address')->nullable();
            $table->string('email', 100)->nullable();
            $table->string('mobile', 30)->nullable();
            $table->string('website', 200)->nullable();
            $table->text('description')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_partner')->nullable();
            $table->text('meta_oem')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
