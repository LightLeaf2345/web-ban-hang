<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Tests\TestCase;

class StorefrontCategoriesTest extends TestCase
{
    public function test_storefront_products_page_shows_categories_from_database(): void
    {
        $category = Category::create([
            'name' => 'Áo khoác test',
            'description' => 'Test category',
            'status' => 'active',
        ]);

        Product::create([
            'category_id' => $category->id,
            'promotion_id' => null,
            'sku' => 'TEST-001',
            'name' => 'Áo khoác test',
            'description' => 'Test product',
            'image' => null,
            'price' => 199000,
            'quantity' => 10,
            'status' => 'active',
        ]);

        $response = $this->get('/products');

        $response->assertStatus(200);
        $response->assertSee($category->name);
    }
}
