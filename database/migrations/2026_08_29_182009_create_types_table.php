<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('type', 50)->index();
            $table->unsignedTinyInteger('data');
            $table->string('description', 50);
            $table->timestamps();

            $table->unique(['type', 'data']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('types');
    }
};
