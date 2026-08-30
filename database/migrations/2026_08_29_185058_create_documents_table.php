<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('uploaded_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name');
            $table->string('path');
            $table->string('file_type', 100)->nullable();
            $table->string('document_type', 200)->nullable();
            $table->unsignedTinyInteger('verification_status')->default(0);
            $table->foreignId('verified_by_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dateTime('verified_at')->nullable();
            $table->text('verification_note')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'document_type']);
            $table->index(['user_id', 'verification_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
