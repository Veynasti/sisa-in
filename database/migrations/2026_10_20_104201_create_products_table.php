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
            $table->id();

            $table->foreignId('merchant_id')
                ->constrained('merchants')
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete();

            $table->string('name');
            $table->text('description')->nullable();

            $table->decimal('normal_price', 12, 2);
            $table->decimal('surplus_price', 12, 2);

            $table->unsignedInteger('stock');

            $table->time('pickup_start');
            $table->time('pickup_end');

            $table->string('photo')->nullable();

            $table->enum('status', [
                'available',
                'sold_out',
                'inactive'
            ])->default('available');

            $table->timestamps();
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
