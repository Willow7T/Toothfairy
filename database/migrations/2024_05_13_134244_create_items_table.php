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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('lab_items', function (Blueprint $table) {
            $table->unsignedBigInteger('lab_id');
            $table->unsignedBigInteger('item_id');
            $table->primary(['lab_id', 'item_id']);
            $table->decimal('price', 8, 2);

            $table->foreign('lab_id')->references('id')->on('labs')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_item');
        Schema::dropIfExists('items');
    }
};
