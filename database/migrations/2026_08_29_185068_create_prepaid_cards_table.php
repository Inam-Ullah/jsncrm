<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prepaid_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->decimal('amount', 12, 2)->default(0);
            $table->unsignedSmallInteger('character_limit')->nullable();
            $table->string('token_prefix', 100)->nullable();
            $table->unsignedTinyInteger('token_combination')->nullable();
            $table->unsignedTinyInteger('type')->nullable();
            $table->foreignId('package_id')->nullable()->constrained('packages')->nullOnDelete();
            $table->foreignId('reseller_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prepaid_cards');
    }
};
