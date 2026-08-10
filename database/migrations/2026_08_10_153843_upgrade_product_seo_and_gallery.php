<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | PRODUCT SEO FIELDS
        |--------------------------------------------------------------------------
        */

        Schema::table('products', function (Blueprint $table) {

            if (!Schema::hasColumn('products', 'canonical_url')) {
                $table->string('canonical_url', 2048)
                    ->nullable()
                    ->after('meta_description');
            }

            if (!Schema::hasColumn('products', 'is_indexable')) {
                $table->boolean('is_indexable')
                    ->default(true)
                    ->after('canonical_url');
            }

            if (!Schema::hasColumn('products', 'og_title')) {
                $table->string('og_title')
                    ->nullable()
                    ->after('is_indexable');
            }

            if (!Schema::hasColumn('products', 'og_description')) {
                $table->text('og_description')
                    ->nullable()
                    ->after('og_title');
            }

            if (!Schema::hasColumn('products', 'og_image')) {
                $table->string('og_image')
                    ->nullable()
                    ->after('og_description');
            }
        });


        /*
        |--------------------------------------------------------------------------
        | VARIANT IMAGE ALT TEXT
        |--------------------------------------------------------------------------
        */

        Schema::table('product_variants', function (Blueprint $table) {

            if (!Schema::hasColumn('product_variants', 'image_alt')) {
                $table->string('image_alt')
                    ->nullable()
                    ->after('image');
            }
        });


        /*
        |--------------------------------------------------------------------------
        | PRODUCT GALLERY IMAGES
        |--------------------------------------------------------------------------
        |
        | One gallery image = one database record.
        |
        | This allows:
        | - individual ALT text
        | - image naming
        | - replace/remove
        | - custom ordering
        |
        */

        if (!Schema::hasTable('product_images')) {

            Schema::create('product_images', function (Blueprint $table) {

                $table->id();

                $table->foreignId('product_id')
                    ->constrained('products')
                    ->cascadeOnDelete();

                $table->string('image');

                $table->string('image_name')
                    ->nullable();

                $table->string('alt_text')
                    ->nullable();

                $table->unsignedInteger('sort_order')
                    ->default(0);

                $table->timestamps();

                $table->index([
                    'product_id',
                    'sort_order',
                ]);
            });
        }


        /*
        |--------------------------------------------------------------------------
        | MIGRATE EXISTING LEGACY GALLERY IMAGES
        |--------------------------------------------------------------------------
        |
        | Existing products currently store gallery images inside:
        |
        | products.gallery_images
        |
        | We copy those existing image paths into product_images so no current
        | gallery is lost when the new one-by-one gallery manager is enabled.
        |
        */

        if (
            Schema::hasColumn('products', 'gallery_images') &&
            Schema::hasTable('product_images')
        ) {

            DB::table('products')
                ->select([
                    'id',
                    'name',
                    'gallery_images',
                ])
                ->orderBy('id')
                ->chunkById(100, function ($products) {

                    foreach ($products as $product) {

                        /*
                        | Do not duplicate data if this migration/backfill
                        | has somehow already been performed.
                        */
                        $alreadyMigrated = DB::table('product_images')
                            ->where('product_id', $product->id)
                            ->exists();

                        if ($alreadyMigrated) {
                            continue;
                        }

                        if (
                            !$product->gallery_images ||
                            trim((string) $product->gallery_images) === ''
                        ) {
                            continue;
                        }

                        $galleryImages = json_decode(
                            $product->gallery_images,
                            true
                        );

                        if (!is_array($galleryImages)) {
                            continue;
                        }

                        foreach (
                            array_values(
                                array_filter($galleryImages)
                            ) as $index => $image
                        ) {

                            if (!is_string($image) || trim($image) === '') {
                                continue;
                            }

                            $image = trim($image);

                            /*
                            |--------------------------------------------------------------------------
                            | Generate a readable image name from filename
                            |--------------------------------------------------------------------------
                            |
                            | Example:
                            | mighty-plus-front.webp
                            |
                            | becomes:
                            | Mighty Plus Front
                            |
                            */

                            $filename = pathinfo(
                                $image,
                                PATHINFO_FILENAME
                            );

                            $imageName = Str::of($filename)
                                ->replace(['_', '-'], ' ')
                                ->squish()
                                ->title()
                                ->toString();

                            DB::table('product_images')->insert([
                                'product_id' => $product->id,

                                'image' => $image,

                                'image_name' => $imageName ?: null,

                                /*
                                | Existing gallery used one global ALT field.
                                | We intentionally leave this null so the new
                                | model can use its sensible fallback until
                                | admin enters a proper image-specific ALT.
                                */
                                'alt_text' => null,

                                'sort_order' => $index,

                                'created_at' => now(),

                                'updated_at' => now(),
                            ]);
                        }
                    }
                });
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Remove Gallery Table
        |--------------------------------------------------------------------------
        */

        Schema::dropIfExists('product_images');


        /*
        |--------------------------------------------------------------------------
        | Remove Variant ALT
        |--------------------------------------------------------------------------
        */

        if (
            Schema::hasTable('product_variants') &&
            Schema::hasColumn(
                'product_variants',
                'image_alt'
            )
        ) {
            Schema::table(
                'product_variants',
                function (Blueprint $table) {
                    $table->dropColumn('image_alt');
                }
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Remove Product SEO Fields
        |--------------------------------------------------------------------------
        */

        $columns = [
            'canonical_url',
            'is_indexable',
            'og_title',
            'og_description',
            'og_image',
        ];

        foreach ($columns as $column) {

            if (Schema::hasColumn('products', $column)) {

                Schema::table(
                    'products',
                    function (Blueprint $table) use ($column) {
                        $table->dropColumn($column);
                    }
                );
            }
        }
    }
};