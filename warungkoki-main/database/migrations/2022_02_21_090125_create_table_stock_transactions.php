<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableStockTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedInteger('wilayah_id');
            $table->foreign('wilayah_id')->references('id')->on('wilayah')->onDelete('cascade');  
            $table->unsignedInteger('destination_id');
            $table->foreign('destination_id')->references('id')->on('wilayah')->onDelete('cascade');  
            $table->date('date')->nullable();
            $table->string('type',20);
            $table->string('jenis',20);
            $table->string('status',50);
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
        Schema::dropIfExists('stock_transactions');
    }
}
