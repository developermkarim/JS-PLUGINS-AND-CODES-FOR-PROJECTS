<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('sub_category_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('sub_sub_category_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->integer('brand_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->string('title');
            $table->string('slug')->unique();
            $table->integer('price');
            $table->integer('qty');
            $table->integer('discount_price')->nullable();
            $table->boolean('status')->default(true);
            $table->string('tags')->nullable();
            $table->string('sizes')->nullable();
            $table->string('colors')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('product_code');
            $table->longText('short_detail')->nullable();
            $table->longText('long_detail')->nullable();
            $table->string('thumbnail_uri')->nullable();
            $table->string('thumbnail_name')->nullable();
            $table->integer('vendor_id')->nullable();
            $table->string('video_uri')->nullable();
            $table->integer('hot_deals')->nullable();
            $table->integer('featured')->nullable();
            $table->integer('special_offer')->nullable();
            $table->integer('special_deals')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};

/* More Professional all type of Column with sample Data */

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->boolean('is_available')->default(true);
            $table->date('manufacture_date');
            $table->dateTime('expiry_date_time');
            $table->uuid('uuid')->unique();
            $table->string('sku')->unique();
            $table->index('name');
            $table->point('location')->nullable();
            $table->virtualAs('quantity * price');
            $table->storedAs('total_price', 'quantity * price');
            $table->comment('A comment about the product');
            $table->string('custom_collation_column')->collation('utf8mb4_bin');
            $table->json('images')->nullable();
            $table->decimal('discounted_price', 10, 2)->nullable();
            $table->dateTime('discount_start')->nullable();
            $table->dateTime('discount_end')->nullable();
            $table->json('multiple_images')->nullable();
            $table->foreignId('category_id')->constrained('categories'); // or
            $table->foreignId('category_id')->constrained()->onUpdate('cascade'); // or
            $table->foreignId('category_id')->constrained()->onDelete('restrict')->onUpdate('restrict');
            $table->foreign(['user_id', 'post_id'])->references(['id', 'post_id'])->on('users_posts')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unsignedBigInteger('sub_sub_category_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->integer('brand_id')->nullable()->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('brand_id')->constrained('brands', 'brand_id');
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('category_id'); // Unsigned big integer for the foreign key
            $table->foreignId('warehouse_id')->constrained('warehouses');
            $table->unsignedBigInteger('user_id');
            $table->softDeletes();
            $table->float('weight')->nullable();
            $table->float('length')->nullable();
            $table->float('width')->nullable();
            $table->float('height')->nullable();
            $table->decimal('average_rating', 3, 2)->nullable();
            $table->integer('total_ratings')->nullable();
            $table->json('variations')->nullable();
            $table->string('url')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamp('downloaded_at')->nullable();
             $table->timestamps(0);


            // Foreign key constraint for UnsignedBigInteger('user_id')

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        
        });

        // Sample data
        DB::table('products')->insert([
            'name' => 'Professional Product',
            'description' => 'This is a product with additional professional features.',
            'price' => 129.99,
            'quantity' => 25,
            'manufacture_date' => '2022-05-01',
            'expiry_date_time' => '2023-05-01 10:00:00',
            'uuid' => Str::uuid(),
            'sku' => 'PRO789',
            'location' => DB::raw('POINT(4, 7)'),
            'category_id' => 3, // Assuming 'categories' table has category with id 3
            'brand_id' => 3, // Assuming 'brands' table has brand with id 3
            'supplier_id' => 1, // Assuming 'suppliers' table has supplier with id 1
            'warehouse_id' => 1, // Assuming 'warehouses' table has warehouse with id 1
            'created_at' => now(),
            'updated_at' => now(),
            'weight' => 5.0,
            'length' => 15.0,
            'width' => 8.0,
            'height' => 12.0,
            'average_rating' => 4.8,
            'total_ratings' => 80,
            'variations' => json_encode(['Color' => ['Silver', 'Gold'], 'Size' => ['Medium', 'X-Large']]),
            'url' => 'https://example.com/professional-product',
            'downloaded_at' => now(),
            'status' => 'active',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}

