<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('orders', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('cashier_id');
			$table->decimal('discount', 15, 2)->nullable();
			$table->enum('discount_type', ['amount', 'percentage'])->nullable();
			$table->datetime('date')->useCurrent();
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
