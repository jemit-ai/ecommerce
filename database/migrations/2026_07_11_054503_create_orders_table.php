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

             // Customer
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            // Order Information
            $table->string('order_number')->unique();

            // Payment
            $table->string('payment_method')->nullable();      // COD, Razorpay, PayPal
            $table->string('payment_id')->nullable();          // Gateway transaction ID
            //$table->string('payment_status')->default('pending'); // pending, paid, failed

            // Order Status
            $table->string('order_status')->default('pending');
            // pending, confirmed, processing, shipped, delivered, cancelled

            $table->timestamps();
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
