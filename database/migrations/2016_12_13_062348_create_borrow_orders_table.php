<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBorrowOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('borrow_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->decimal('amount',15,4);
            $table->date('borrow_date');
            $table->integer('borrow_id');
            $table->integer('days');
            $table->decimal('rate',15,4);
            $table->integer('status');
            $table->string('symbol');
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
        Schema::dropIfExists('borrow_orders');
    }
}
