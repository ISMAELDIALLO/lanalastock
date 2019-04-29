<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoriqueArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historique_articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('article')->nullable();
            $table->string('dateDebutContrat')->nullable();
            $table->string('dateFinContrat')->nullable();
            $table->double('prixUnitaire')->nullable();
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
        Schema::dropIfExists('historique_articles');
    }
}
