<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFournisseursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fournisseurs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('categorie_fournisseurs_id')->index()->foreign('categorie_fournisseurs_id')->references('id')->on('categorie_fournisseurs')->onDelete('cascade');
            $table->string('codeFournisseur');
            $table->string('nomSociete');
            $table->string('nomDuContact');
            $table->string('prenomDuContact');
            $table->string('telephoneDuContact');
            $table->string('observation')->nullable();
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
        Schema::dropIfExists('fournisseurs');
    }
}
