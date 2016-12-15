<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKlinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('klines', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->datetime('create_date');
            $table->decimal('start_price',15,4);
            $table->decimal('high_price',15,4);
            $table->decimal('low_price',15,4);
            $table->decimal('over_price',15,4);
            $table->decimal('dif_price',15,4);
            $table->decimal('vol',15,4);
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
        Schema::dropIfExists('klines');
    }
}
