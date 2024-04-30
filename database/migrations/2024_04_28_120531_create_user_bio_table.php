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
        Schema::create('user_bio', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key reference to users table
            
            // Columns for user bio information
            $table->date('birthday')->nullable();
            $table->integer('age')->nullable();
            $table->enum('sex', ['male', 'female', 'other'])->nullable();
            $table->text('medical_info')->nullable();
            $table->string('phone_no')->nullable();
            $table->text('address')->nullable();
            
            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Timestamps
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_bio');
    }
};
