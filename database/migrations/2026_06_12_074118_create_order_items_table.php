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
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('order_id')->index('fk_orderitem_order');
            $table->bigInteger('product_id')->index('fk_orderitem_product');
            $table->integer('quantity');
            $table->decimal('price', 12);
            $table->decimal('subtotal', 12);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
