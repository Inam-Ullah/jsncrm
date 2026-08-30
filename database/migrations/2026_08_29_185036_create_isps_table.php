<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('isps', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 100);
            $table->string('poc_name', 50);
            $table->string('mobile', 30);
            $table->string('address', 255);
            $table->unsignedBigInteger('city_id')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('isps');
    }
};
