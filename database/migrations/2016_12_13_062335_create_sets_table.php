<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->decimal('base_price',15,4);
            $table->decimal('my_last_price',15,4);
            $table->decimal('unit',15,4);
            $table->decimal('n_price',15,4);
            $table->string('last_trade_type');
            $table->integer('last_trade_hits');
            $table->decimal('uprate',15,4);
            $table->decimal('downrate',15,4);
            $table->decimal('upline',15,4);
            $table->decimal('downline',15,4);
            $table->date('create_date');
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
        Schema::dropIfExists('sets');
    }
}
