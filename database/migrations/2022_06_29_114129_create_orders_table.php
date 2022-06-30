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
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('from_currency_id')->unsigned();
            $table->foreign('from_currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->bigInteger('to_currency_id')->unsigned();
            $table->foreign('to_currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->string('fromImage');
            $table->string('fromCode');
            $table->string('toImage');
            $table->string('toCode');
            $table->decimal('sum', 10, 5);
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
