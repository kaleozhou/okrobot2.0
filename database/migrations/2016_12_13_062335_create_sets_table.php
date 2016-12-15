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
            $table->decimal('my_last_price',15,4);
            $table->decimal('unit',15,4);
            $table->decimal('unitrate',15,4);
            $table->decimal('n_price',15,4);
            $table->decimal('uprate',15,4);
            $table->decimal('downrate',15,4);
            $table->decimal('upline',15,4);
            $table->decimal('downline',15,4);
            $table->datetime('create_date');
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
