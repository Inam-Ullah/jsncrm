<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('token_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->nullable();
            $table->unsignedSmallInteger('character_limit')->nullable();
            $table->string('prefix', 100)->nullable();
            $table->unsignedTinyInteger('combination')->nullable();
            $table->foreignId('package_id')->nullable()->constrained('packages')->nullOnDelete();
            $table->foreignId('reseller_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedBigInteger('nas_id')->nullable();
            $table->text('note')->nullable();
            $table->boolean('status')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->foreign('nas_id')->references('id')->on('nas')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('token_cards');
    }
};
