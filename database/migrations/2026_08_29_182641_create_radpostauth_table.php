<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('radpostauth', function (Blueprint $table) {
            $table->id();
            $table->string('username', 64)->default('')->index();
            $table->string('pass', 64)->default('');
            $table->string('reply', 32)->default('');
            $table->string('nasipaddress')->nullable();
            $table->string('nasportid')->nullable();
            $table->string('mac')->nullable();
            $table->timestamp('authdate', 6)->useCurrent()->useCurrentOnUpdate()->index();
            $table->string('class', 64)->nullable()->index();
            $table->index(['username', 'authdate'], 'username_authdate');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('radpostauth');
    }
};
