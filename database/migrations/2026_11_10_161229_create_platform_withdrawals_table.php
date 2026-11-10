<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('platform_withdrawals', function (Blueprint $table) {
            $table->id();

            $table->string('withdrawal_number')->unique();
            $table->decimal('amount', 12, 2);

            $table->date('withdrawal_date');

            $table->string('destination_account');
            $table->string('account_holder');

            $table->text('description')->nullable();
            $table->string('proof')->nullable();

            $table->foreignId('admin_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('platform_withdrawals');
    }
};
