<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('radpostauth_archive', function (Blueprint $table) {
            $table->id();
            $table->string('username', 64)->default('')->index();
            $table->string('pass', 64)->default('');
            $table->string('reply')->default('');
            $table->timestamp('authdate')->useCurrent()->useCurrentOnUpdate()->index();
            $table->string('nasipaddress', 15)->nullable();
            $table->string('nasportid', 100)->nullable();
            $table->mediumText('mac')->nullable();
            $table->index(['username', 'authdate'], 'username_authdate');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('radpostauth_archive');
    }
};
