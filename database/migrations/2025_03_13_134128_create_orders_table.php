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
            $table->id();
            $table->unsignedBigInteger('cashier_id');
            $table->string('order_number');
            $table->integer('discount')->nullable();
            $table->enum('discount_type', ['flat', 'percentage'])->nullable();
            $table->datetime('date')->useCurrent();
            $table->enum('status', ['pending', 'preparing', 'completed', 'cancelled']);
            $table->unsignedBigInteger('payment_method_id');
            $table->timestamps();

            $table->foreign('cashier_id')->references('id')->on('cashiers');
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');
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
