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
        Schema::create('delivery_personnels', function (Blueprint $table) {
            $table->id();   
            $table->string('name');   
            $table->enum('skill_level', ['beginner', 'intermediate', 'expert']); 
            $table->integer('max_orders');   
            $table->enum('specialization', ['urgent', 'standard', 'low']);  
            $table->integer('current_orders')->default(0);  
            $table->timestamp('last_assigned_at')->nullable();
            $table->timestamps();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_personnels');
    }
};
