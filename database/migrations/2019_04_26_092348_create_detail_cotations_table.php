<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailCotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_cotations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cotations_id')->index()->foreign('cotations_id')->references('id')->on('coatations')->onDelete('cascade');
            $table->integer('articles_id')->index()->foreign('articles_id')->references('id')->on('articles')->onDelete('cascade');
            $table->integer('quantite');

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
        Schema::dropIfExists('detail_cotations');
    }
}
