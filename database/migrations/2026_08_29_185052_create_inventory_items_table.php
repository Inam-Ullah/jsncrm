<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventory_item_type_id')->constrained('inventory_item_types')->restrictOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name', 100);
            $table->unsignedTinyInteger('condition');
            $table->unsignedInteger('quantity')->default(0);
            $table->decimal('price', 12, 2)->default(0);
            $table->string('company', 100)->nullable();
            $table->string('model', 100)->nullable();
            $table->string('capacity', 100)->nullable();
            $table->string('seller', 100)->nullable();
            $table->date('warranty_until')->nullable();
            $table->boolean('is_for_sale')->default(false);
            $table->string('dimensions', 100)->nullable();
            $table->string('color', 100)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};
