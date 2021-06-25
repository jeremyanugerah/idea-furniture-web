<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->unsignedBigInteger('product_type_id')->nullable(false);
            $table->integer('stock')->nullable(false);
            $table->integer('price')->nullable(false);
            $table->text('description')->nullable(false);
            $table->text('image')->nullable(true);
            $table->timestamps();
            $table->foreign('product_type_id')->references('id')->on('product_types')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
