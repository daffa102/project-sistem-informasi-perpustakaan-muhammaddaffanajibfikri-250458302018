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
            $table->uuid('id')->primary();
            $table->foreignId('fine_id')->constrained()->onDelete('cascade');
            $table->foreignId('member_id')->constrained()->onDelete('cascade');
            $table->string('order_id')->unique();
            $table->decimal('amount', 10, 2);
            $table->string('payment_type')->nullable();
            $table->string('transaction_status')->default('pending');
            $table->string('transaction_id')->nullable();
            $table->text('snap_token')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->json('midtrans_response')->nullable();
            $table->timestamps();
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
