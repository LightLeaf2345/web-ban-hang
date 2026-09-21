<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('category_id')->index('idx_product_category');
            $table->bigInteger('promotion_id')->nullable()->index('fk_product_promotion');
            $table->string('sku', 50)->nullable()->unique('sku');
            $table->string('name')->index('idx_product_name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price', 12);
            $table->integer('quantity')->default(0);
            $table->enum('status', ['active', 'inactive'])->nullable()->default('active');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
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
