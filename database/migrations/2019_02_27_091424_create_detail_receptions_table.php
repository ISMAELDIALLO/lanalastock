<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailReceptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_receptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('receptions_id')->index()->foreign('receptions_id')->references('id')->on('receptions')->onDelete('cascade');
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
        Schema::dropIfExists('detail_receptions');
    }
}
