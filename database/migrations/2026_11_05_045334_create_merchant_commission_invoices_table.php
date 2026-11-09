<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('merchant_commission_invoices', function (Blueprint $table) {
            $table->id();

            $table->foreignId('merchant_id')
                ->constrained('merchants')
                ->restrictOnDelete();

            $table->string('invoice_number')->unique();

            $table->date('period_start');

            $table->date('period_end');

            $table->decimal('total_commission', 12, 2);

            $table->enum('status', [
                'unpaid',
                'pending_verification',
                'paid',
                'overdue'
            ])->default('unpaid');

            $table->date('due_date')->nullable();

            $table->timestamp('paid_at')->nullable();

            $table->string('payment_method')->nullable();

            $table->string('payment_reference')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('merchant_commission_invoices');
    }
};
