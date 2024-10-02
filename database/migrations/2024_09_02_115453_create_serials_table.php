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
        Schema::create('serials', function (Blueprint $table) {
            $table->id();
            $table->string('serial_no')->nullable();
            $table->string('barcode_no')->nullable();
            $table->string('color')->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('return_status')->default(0);
            $table->foreignId('stock_id')->constrained('stocks')->onDelete('cascade'); 
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serials');
    }
    
};
