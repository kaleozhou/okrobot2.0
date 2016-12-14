<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserinfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userinfos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->decimal('asset_net',15,4);
            $table->decimal('asset_total',15,4);
            $table->decimal('borrow_btc',15,4);
            $table->decimal('borrow_cny',15,4);
            $table->decimal('borrow_ltc',15,4);
            $table->decimal('free_btc',15,4);
            $table->decimal('free_cny',15,4);
            $table->decimal('free_ltc',15,4);
            $table->decimal('freezed_btc',15,4);
            $table->decimal('freezed_cny',15,4);
            $table->decimal('freezed_ltc',15,4);
            $table->string('union_fund');
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
        Schema::dropIfExists('userinfos');
    }
}
