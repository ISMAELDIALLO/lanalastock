<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('famille_articles_id')->index()->foreign('famille_articles_id')->references('id')->on('famille_articles')->onDelete('cascade');
            $table->string('referenceArticle');
            $table->string('libelleArticle');
            $table->integer('quantiteMinimum');
            $table->integer('quantiteMaximum');
            $table->double('dernierPrix');
            $table->date('dateInventaire')->nullable();
            $table->integer('quantiteInventaire')->nullable();
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
        Schema::dropIfExists('articles');
    }
}
