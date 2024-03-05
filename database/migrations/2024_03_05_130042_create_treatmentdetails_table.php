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
        Schema::disableForeignKeyConstraints();

        Schema::create('treatmentdetails', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->longText('description');
            $table->foreignId('patient_id')->constrained('users');
            $table->foreignId('dentist_id')->constrained('users');
            $table->foreignId('treatment_id')->constrained();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treatmentdetails');
    }
};