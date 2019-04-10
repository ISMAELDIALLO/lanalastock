<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codeDemande');
            $table->date('dateDemande');
            $table->integer('users_id')->index()->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('etat')->default(0);
            //Un statut qui indique si la demande est validée,rejettée ou mise en attente
            $table->integer('statut');
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
        Schema::dropIfExists('demandes');
    }
}
