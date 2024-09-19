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
        Schema::create('reserves', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_type')->nullable()->default('0');
            $table->integer('amount')->nullable();
            $table->string('status')->nullable()->default('0');

            // Foreign key columns
            $table->unsignedBigInteger('expense_id')->nullable();
            $table->unsignedBigInteger('payment_type_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('investment_id')->nullable();
            $table->unsignedBigInteger('bill_id')->nullable();
            
            $table->foreign('expense_id')->references('id')->on('expenses')->onDelete('set null');
            $table->foreign('payment_type_id')->references('id')->on('paymenttypes')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('investment_id')->references('id')->on('investments')->onDelete('set null');
            $table->foreign('bill_id')->references('id')->on('bills')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reserves');
    }
};
