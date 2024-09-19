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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('bill_id')->nullable();
            $table->integer('total_price')->nullable();
            // $table->integer('quantity')->nullable();
            // $table->integer('price')->nullable();
            $table->string('status')->default('1'); // Ensure status is a string if default is a string

            $table->foreignId('customer_id')->nullable()->constrained('customers')->onDelete('set null');
            // $table->foreignId('paymenttype_id')->nullable()->constrained('paymenttypes')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            // $table->foreignId('serial_id')->constrained('serials')->onDelete('cascade');

            // Add foreign key for cart_id
            $table->foreignId('cart_id')->nullable()->constrained('carts')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
