<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('crypto_histories', function (Blueprint $table) {
            $table->id();
            $table->string('interval');
            $table->double('current_price');
            $table->dateTime('date');

            $table->unsignedBigInteger('crypto_id');
            $table->foreign('crypto_id')->references('id')->on('cryptos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('crypto_histories');
    }
}

