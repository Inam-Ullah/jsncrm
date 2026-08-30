<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_bandwidth_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->time('start_time');
            $table->time('end_time');
            $table->string('group_name', 64)->index();
            $table->unsignedTinyInteger('sort_order')->default(1);
            $table->timestamps();

            $table->unique(['package_id', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_bandwidth_schedules');
    }
};
