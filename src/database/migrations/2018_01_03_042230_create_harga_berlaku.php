<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHargaBerlaku extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hargaberlaku', function (Blueprint $table) {
            $table->increments('hargaberlakuid');
            $table->integer('hargaberlakuvalue');
            $table->date('hargaberlakutgl');
            $table->string('hargaberlakuprovincekode');
            $table->string('hargaberlakukotakode');
            $table->integer('hargaberlakucreateby');
            $table->date('hargaberlakucreatedate');
            $table->integer('hargaberlakustatus');
            $table->integer('hargaberlakulogid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('hargaberlaku');
    }
}
