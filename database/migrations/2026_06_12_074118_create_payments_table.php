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
        Schema::create('payments', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->bigInteger('order_id')->index('fk_payment_order');
            $table->decimal('amount', 12);
            $table->enum('payment_method', ['COD', 'BANKING', 'MOMO', 'ZALOPAY'])->nullable()->default('COD');
            $table->enum('payment_status', ['pending', 'paid', 'failed'])->nullable()->default('pending');
            $table->string('transaction_code', 100)->nullable();
            $table->dateTime('payment_date')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
