<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailComptesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_comptes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('comptes_id')->index()->foreign('comptes_id')->references('id')->on('comptes')->onDelete('cascade');
            $table->double('montant')->nullable();
            $table->date('date');
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
        Schema::dropIfExists('detail_comptes');
    }
}
