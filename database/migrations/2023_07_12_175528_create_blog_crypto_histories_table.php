<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogCryptoHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('blog_crypto_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blog_id');
            $table->unsignedBigInteger('crypto_history_id');
            $table->timestamps();

            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
            $table->foreign('crypto_history_id')->references('id')->on('crypto_histories')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('blog_crypto_histories');
    }
}
