<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBorrowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->decimal('borrow_btc',15,4);
            $table->decimal('borrow_ltc',15,4);
            $table->decimal('borrow_cny',15,4);
            $table->decimal('can_borrow',15,4);
            $table->decimal('interest_btc',15,4);
            $table->decimal('interest_ltc',15,4);
            $table->decimal('interest_cny',15,4);
            $table->decimal('today_interest_btc',15,4);
            $table->decimal('today_interest_ltc',15,4);
            $table->decimal('today_interest_cny',15,4);
            $table->boolean('result');
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
        Schema::dropIfExists('borrows');
    }
}
