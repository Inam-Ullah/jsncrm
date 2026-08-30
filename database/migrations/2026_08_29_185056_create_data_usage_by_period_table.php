<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('data_usage_by_period', function (Blueprint $table) {
            $table->string('username', 64);
            $table->dateTime('period_start');
            $table->dateTime('period_end')->nullable()->index();
            $table->bigInteger('acctinputoctets')->nullable();
            $table->bigInteger('acctoutputoctets')->nullable();

            $table->primary(['username', 'period_start']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('data_usage_by_period');
    }
};
