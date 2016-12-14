<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTickersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->decimal('buy',15,4);
            $table->decimal('high',15,4);
            $table->decimal('last_price',15,4);
            $table->decimal('low',15,4);
            $table->decimal('sell',15,4);
            $table->decimal('base_rate',15,4);
            $table->decimal('dif_price',15,4);
            $table->decimal('vol',15,4);
            $table->date('tickerdate');
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
        Schema::dropIfExists('tickers');
    }
}
