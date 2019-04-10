<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailSortieStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_sortie_stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('articles_id')->nullable()->index()->foreign('articles_id')->references('id')->on('articles')->onDelete('cascade');
            $table->integer('quantiteSortante')->nullable();
            $table->integer('quantiteDemandee')->nullable();
            $table->double('prix')->nullable();
            $table->integer('detailDemandes_id')->nullable()->index()->foreign('detailDemandes_id')->references('id')->on('detailDemandes')->onDelete('cascade');
            $table->string('motif')->nullable();
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
        Schema::dropIfExists('detail_sortie_stocks');
    }
}
