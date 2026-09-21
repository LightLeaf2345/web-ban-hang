<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCategoryTest extends TestCase
{
    use RefreshDatabase;
    public function test_admin_can_create_category_and_persist_to_database(): void
    {
        $response = $this->postJson('/admin/categories', [
            'name' => 'Áo sơ mi',
            'status' => 'active',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('category.name', 'Áo sơ mi');

        $this->assertDatabaseHas('categories', [
            'name' => 'Áo sơ mi',
            'status' => 'active',
        ]);
    }
}
