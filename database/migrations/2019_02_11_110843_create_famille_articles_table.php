<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFamilleArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('famille_articles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('super_categories_id')->index()->foreign('super_categories_id')->references('id')->on('super_categorie_articles')->onDelete('cascade');
            $table->string('typeImputation');
            $table->string('codeFamilleArticle');
            $table->string('libelleFamilleArticle');
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
        Schema::dropIfExists('famille_articles');
    }
}
