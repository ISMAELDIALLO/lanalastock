<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailDemandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_demandes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('demandes_id')->index()->foreign('demandes_id')->references('id')->on('detailDemandes')->onDelete('cascade');
            $table->integer('articles_id')->index()->foreign('articles_id')->references('id')->on('articles')->onDelete('cascade');
            $table->integer('quantiteDemandee');
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
        Schema::dropIfExists('detail_demandes');
    }
}
