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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expenser_id')->constrained('users')->onDelete('cascade');
            $table->text('expense_desc')->nullable();
            $table->integer('amount');
            $table->string('cost_type');
            $table->string('date');
            $table->string('status')->nullable()->default(0);
            $table->string('receipt_img')->nullable()->default(null);
            $table->foreignId('expense_category_id')->constrained('expensecategories')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('payment_type_id')->constrained('paymenttypes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
