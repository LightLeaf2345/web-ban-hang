<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class ExcelImportTest extends TestCase
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

    public function test_import_endpoint_creates_product_from_vietnamese_csv_headers(): void
    {
        $csv = "Tên sản phẩm,SKU,Giá,Số lượng,Danh mục,Miêu tả\nÁo thun test,TEST-001,199000,12,Áo Nam,Áo test nhập từ CSV\n";

        $file = UploadedFile::fake()->createWithContent('products.csv', $csv);

        $response = $this->post('/admin/products/import', [
            'excel_file' => $file,
        ]);

        $response->assertStatus(200);
        $response->assertJsonPath('success', true);

        $product = Product::where('sku', 'TEST-001')->first();
        $this->assertNotNull($product);
        $this->assertSame('Áo thun test', $product->name);
        $this->assertSame(199000, (int) $product->price);
        $this->assertSame(12, $product->quantity);
        $this->assertNotNull($product->category_id);
        $this->assertSame('Áo Nam', $product->category->name);
    }
}
