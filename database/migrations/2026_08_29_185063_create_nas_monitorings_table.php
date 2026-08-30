<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nas_monitorings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nas_id');
            $table->string('nas_ip', 100);
            $table->boolean('status');
            $table->dateTime('checked_at');
            $table->timestamps();

            $table->foreign('nas_id')->references('id')->on('nas')->cascadeOnDelete();
            $table->index(['nas_id', 'checked_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nas_monitorings');
    }
};
