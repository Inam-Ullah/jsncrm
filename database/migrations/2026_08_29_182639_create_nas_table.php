<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nas', function (Blueprint $table) {
            $table->id();
            $table->string('nasname', 128);
            $table->string('shortname', 32)->nullable();
            $table->string('type', 30)->nullable()->default('other');
            $table->integer('ports')->nullable();
            $table->string('secret', 60)->default('secret');
            $table->string('server', 64)->nullable();
            $table->string('community', 50)->nullable();
            $table->string('description', 200)->nullable()->default('RADIUS Client');
            $table->integer('nasapi')->nullable();
            $table->string('nasip', 100)->nullable();
            $table->string('nasusername', 100)->nullable();
            $table->string('naspassword', 100)->nullable();
            $table->integer('parent')->nullable();
            $table->dateTime('checkedTime')->nullable();
            $table->integer('status')->nullable();
            $table->integer('api_port')->nullable();
            $table->integer('incoming_port')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nas');
    }
};
