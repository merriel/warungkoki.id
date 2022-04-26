<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableKeranjangReedemPoint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keranjang_reedem_point', function (Blueprint $table) {
            $table->bigIncrements('id', true, 9);
            $table->Integer('user_id');
            $table->Integer('id_bracket_product');
            $table->Integer('post_id')->nullable();
            $table->foreign(['post_id'])
                ->references(['id'])->on('posts');
            $table->Integer('qty')->nullable();;
            $table->String('jam',20);
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
        Schema::dropIfExists('keranjang_reedem_point');
    }
}
