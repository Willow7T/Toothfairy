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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            //user_id but patient role
            $table->unsignedBigInteger('patient_id')->constrained('users')->onDelete('cascade');
            //user_id but doctor role
            $table->unsignedBigInteger('dentist_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('appointment_date')->nullable();
            $table->enum('status', ['pending','cancelled', 'completed'])->default('pending');
            $table->decimal('calculated_fee', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('total_fee', 10, 2)->nullable();
            $table->mediumText('description')->nullable();
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('dentist_id')->references('id')->on('users')->onDelete('cascade');

        });
        Schema::create('appointment_treatment', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->foreignId('appointment_id')->constrained()->onDelete('cascade'); // Foreign key to the appointments table
            $table->foreignId('treatment_id')->constrained()->onDelete('cascade'); // Foreign key to the treatments table
            $table->integer('quantity')->default(1); // Quantity of the treatment at the time of appointment
            $table->decimal('price', 10, 2)->nullable(); // Price of the treatment at the time of appointment
            $table->timestamps(); // Timestamps for created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_treatments');
        Schema::dropIfExists('appointments');
    }
};
