<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('merchant_commission_invoices', function (Blueprint $table) {
            $table->string('payment_proof')->nullable();

            $table->foreignId('verified_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('rejection_reason')->nullable();

            $table->timestamp('submitted_at')->nullable();

            $table->timestamp('verified_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('merchant_commission_invoices', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);

            $table->dropColumn([
                'payment_proof',
                'verified_by',
                'rejection_reason',
                'submitted_at',
                'verified_at',
            ]);
        });
    }
};
