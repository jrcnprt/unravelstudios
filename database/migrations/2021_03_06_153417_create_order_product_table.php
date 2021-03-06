<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('order_product')) {
            Schema::create('order_product', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('order_id')->unsigned()->nullable();

                $table->integer('product_id')->unsigned()->nullable();
                $table->foreign('product_id')->references('id')
                ->on('products')->onUpdate('cascade')->onDelete('set null');

                $table->integer('quantity')->unsigned();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_products');
    }
}
