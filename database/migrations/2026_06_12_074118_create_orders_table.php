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
        Schema::create('orders', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('user_id')->index('idx_order_user');
            $table->dateTime('order_date')->nullable()->useCurrent();
            $table->text('shipping_address')->nullable();
            $table->decimal('total_amount', 12);
            $table->enum('status', ['pending', 'confirmed', 'shipping', 'completed', 'cancelled'])->nullable()->default('pending');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
