<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_id')
                ->constrained();
            $table->foreignId('client_id')
                ->constrained();
            $table->foreignId('user_id')
                ->constrained();

            $table->timestamp("scheduled_at");

            $table->string('status');
            $table->string('payment_method')->nullable();
            $table->decimal('total',7 ,2 );
            
            $table->string('observation', 255)->nullable();
                
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
}
