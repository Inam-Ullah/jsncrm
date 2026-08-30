<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('areas')
                ->nullOnDelete();
            $table->enum('type', ['city', 'area', 'sub_area'])->index();
            $table->string('name', 100);
            $table->timestamps();

            $table->unique(['parent_id', 'type', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
};
