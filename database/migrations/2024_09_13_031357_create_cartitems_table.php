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
        Schema::create('cartitems', function (Blueprint $table) {
            $table->id();
            $table->string('item_no')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('price')->nullable();
            $table->string('status')->nullable()->default('1');

            // Foreign key columns
            $table->unsignedBigInteger('cart_id')->nullable();
            $table->unsignedBigInteger('serial_id')->nullable();
            // $table->unsignedBigInteger('payment_type_id')->nullable();

            // Foreign key constraints
            $table->foreign('cart_id')->references('id')->on('carts')->onDelete('set null');
            $table->foreign('serial_id')->references('id')->on('serials')->onDelete('set null');
            // $table->foreign('payment_type_id')->references('id')->on('paymenttypes')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cartitems');
    }
};
