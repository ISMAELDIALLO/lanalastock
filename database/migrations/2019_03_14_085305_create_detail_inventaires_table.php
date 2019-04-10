<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailInventairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_inventaires', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('inventaires_id')->index()->foreign('inventaires_id')->references('id')->on('inventaires')->onDelete('cascade');
            $table->integer('articles_id')->index()->foreign('articles_id')->references('id')->on('articles')->onDelete('cascade');
            $table->integer('quantiteTheorique');
            $table->integer('quantitePhysique');
            $table->string('slug');
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
        Schema::dropIfExists('detail_inventaires');
    }
}
