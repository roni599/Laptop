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
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->string('In_name');
            $table->integer('Amount');
            $table->string('date');
            $table->string('status')->nullable()->default(0);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('paymenttype_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('paymenttype_id')->references('id')->on('paymenttypes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investments');
    }
};
