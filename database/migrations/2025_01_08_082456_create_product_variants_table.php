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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            $table->string('sku')->unique();
            $table->decimal('price', 10, 2);

            $table->boolean('manage_stock')->default(1);
            $table->integer('stock')->default(0);

            $table->boolean('has_discount')->default(0);
            $table->decimal('discount', 5, 2)->nullable();
            $table->date('start_discount')->nullable();
            $table->date('end_discount')->nullable();

            $table->timestamps();
            $table->index('stock');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
