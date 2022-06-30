<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currency_rates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('from_currency_id')->unsigned();
            $table->foreign('from_currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->bigInteger('to_currency_id')->unsigned();
            $table->foreign('to_currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->float('reserve', 10, 2);
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
        Schema::dropIfExists('currency_rates');
    }
}
