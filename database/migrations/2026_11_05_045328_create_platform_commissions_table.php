<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('platform_commissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            $table->foreignId('merchant_id')
                ->constrained('merchants')
                ->restrictOnDelete();

            $table->decimal('gross_amount', 12, 2);

            $table->decimal('commission_rate', 5, 2)->default(5.00);

            $table->decimal('commission_amount', 12, 2);

            $table->decimal('merchant_amount', 12, 2);

            $table->string('payment_method');

            $table->enum('collection_status', [
                'pending',
                'invoiced',
                'paid',
                'reversed'
            ])->default('pending');

            $table->timestamps();

            $table->unique(
                ['order_id', 'merchant_id'],
                'unique_order_merchant_commission'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('platform_commissions');
    }
};
