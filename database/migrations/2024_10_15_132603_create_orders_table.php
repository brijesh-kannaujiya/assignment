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
            $table->enum('urgency_level', ['urgent', 'standard', 'low']);  
            $table->integer('duration_minutes');  
            $table->enum('delivery_distance', ['short', 'medium', 'long']);   
            $table->enum('status', ['pending', 'assigned', 'delivered'])->default('pending');   
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
