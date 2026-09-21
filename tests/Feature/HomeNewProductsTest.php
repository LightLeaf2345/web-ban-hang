<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class HomeNewProductsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');

        Schema::create('categories', function ($table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        Schema::create('products', function ($table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('promotion_id')->nullable();
            $table->string('sku')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price', 12, 0)->default(0);
            $table->integer('quantity')->default(0);
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    public function test_home_page_shows_latest_products_on_new_arrivals_section(): void
    {
        $category = Category::create([
            'name' => 'Áo khoác',
            'description' => 'Test category',
            'status' => 'active',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'promotion_id' => null,
            'sku' => 'NEW-001',
            'name' => 'Áo khoác mới',
            'description' => 'Test new product',
            'image' => null,
            'price' => 299000,
            'quantity' => 15,
            'status' => 'active',
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Hàng Mới Lên Kệ');
        $response->assertSee($product->name);
    }
}
