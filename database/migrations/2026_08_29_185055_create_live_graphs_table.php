<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('live_graphs', function (Blueprint $table) {
            $table->id();
            $table->string('username', 100)->index();
            $table->unsignedBigInteger('download_bytes')->default(0);
            $table->unsignedBigInteger('upload_bytes')->default(0);
            $table->dateTime('last_updated_at');
            $table->timestamps();

            $table->index(['username', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('live_graphs');
    }
};
