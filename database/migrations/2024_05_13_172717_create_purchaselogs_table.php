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
        Schema::create('purchaselogs', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_expense', 12, 2)->nullable();
            $table->date('purchase_date');
            $table->mediumText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('purchaselog_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchaselog_id');
            $table->unsignedBigInteger('labitem_id');
            $table->integer('quantity');
            $table->decimal('price', 12, 2);
            $table->timestamps();


            $table->foreign('purchaselog_id')->references('id')->on('purchaselogs')->onDelete('cascade');
            $table->foreign('labitem_id')->references('id')->on('lab_items')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchaselog_item');
        Schema::dropIfExists('purchaselogs');
    }
};
