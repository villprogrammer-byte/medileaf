<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            // Basic Information
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('sku')->nullable()->unique();
            $table->string('category')->nullable();
            $table->string('brand')->nullable();
            $table->string('product_type')->nullable();
            $table->json('colors')->nullable();

            // Pricing
            $table->decimal('regular_price', 10, 2)->default(0);
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->decimal('cost_price', 10, 2)->nullable();

            // Description
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            // Inventory
            $table->integer('stock_quantity')->default(0);
            $table->integer('low_stock_alert')->default(5);

            $table->enum('stock_status', [
                'in_stock',
                'out_of_stock',
                'low_stock'
            ])->default('in_stock');

            // Images
            $table->string('featured_image')->nullable();
            $table->json('gallery_images')->nullable();

            // Shipping
            $table->decimal('weight', 8, 2)->nullable();
            $table->decimal('length', 8, 2)->nullable();
            $table->decimal('width', 8, 2)->nullable();
            $table->decimal('height', 8, 2)->nullable();

            // SEO
            $table->string('seo_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('image_alt')->nullable();

            // Product Options
            $table->boolean('featured')->default(false);
            $table->boolean('prescription_required')->default(false);

            $table->enum('status', [
                'published',
                'draft',
                'hidden'
            ])->default('draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};