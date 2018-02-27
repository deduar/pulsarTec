<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaypalTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paypal_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('transaction_id');
            $table->double('amount');
            $table->enum('currency',['USD','EUR']);
            $table->double('tax');
            $table->double('shipping');
            $table->timestamp('created_at');
            $table->timestamp('updated_at');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paypal_transactions');
    }
}
