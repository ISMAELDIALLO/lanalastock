<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineDeCommandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_de_commandes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('commandes_id')->index()->foreign('commandes_id')->references('id')->on('commandes')->onDelete('cascade');
            $table->integer('articles_id')->index()->foreign('articles_id')->references('id')->on('articles')->onDelete('cascade');
            $table->integer('quantite');
            $table->double('prixUnitaire');
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
        Schema::dropIfExists('line_de_commandes');
    }
}
