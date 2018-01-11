<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Lpeprovinsi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lpeprovinsi', function (Blueprint $table) {
            $table->increments('lpeprovinsiid');
            $table->string('lpeprovinsivalue');
            $table->date('lpeprovinsitgl');
            $table->string('lpeprovinsiprovincekode');
            $table->string('lpeprovinsikotakode');
            $table->date('lpeprovinsicreatedate');
            $table->integer('lpeprovinsicreateby');
            $table->integer('lpeprovinsistatus');
            $table->integer('lpeprovinsilogid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lpeprovinsi');
    }
}
