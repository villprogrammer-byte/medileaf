<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->string('colour_name', 100);
            $table->string('colour_code', 20)->nullable();
            $table->string('sku', 100)->unique();
            $table->unsignedInteger('quantity')->default(0);
            $table->string('image')->nullable();
            $table->decimal('price_adjustment', 10, 2)->default(0);

            $table->enum('status', [
                'active',
                'inactive',
            ])->default('active');

            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['product_id', 'status']);
            $table->index(['product_id', 'sort_order']);
            $table->unique(['product_id', 'colour_name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
