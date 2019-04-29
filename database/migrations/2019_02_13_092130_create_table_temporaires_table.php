<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTemporairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_temporaires', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('articles');
            $table->integer('quantite');
            $table->double('prixUnitaire')->nullable();
            $table->integer('fournisseurs_id')->nullable();
            $table->integer('cotations_id')->nullable();
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
        Schema::dropIfExists('table_temporaires');
    }
}
