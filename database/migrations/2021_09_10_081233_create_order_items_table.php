<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->foreignId('order_id')
                ->constrained();
            $table->foreignId('service_id')
                ->nullable()
                ->constrained();
            $table->foreignId('product_id')
                ->nullable()
                ->constrained();
                
            $table->integer('quantity')->default(1);
            $table->decimal('original_price',5 ,2 );
            $table->decimal('price',5 ,2 );
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
}
