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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 50);
            $table->string('name', 225);
            $table->string('slug', 225)->index();
            $table->string('description', 225);
            $table->integer('id_brand')->index();
            $table->integer('id_product_category')->index();
            $table->integer('id_cutting')->index();
            $table->integer('price_3');
            $table->integer('price_5');
            $table->integer('price_10');
            $table->integer('price_15');
            $table->float('discount')->default(0);
            $table->date('lauch_date');
            $table->boolean('new')->default(false);
            $table->boolean('best')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
