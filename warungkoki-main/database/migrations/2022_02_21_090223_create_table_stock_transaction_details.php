<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableStockTransactionDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_transaction_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('stocktransaction_id');
            $table->foreign('stocktransaction_id')->references('id')->on('stock_transactions')->onDelete('cascade');
            $table->Integer('post_id'); 
            $table->string('qty',20);
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
        Schema::dropIfExists('stock_transaction_details');
    }
}
