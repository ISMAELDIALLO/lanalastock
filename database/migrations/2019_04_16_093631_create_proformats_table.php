<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProformatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proformats', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fournisseurs_id')->index()->foreign('fournisseurs_id')->references('id')->on('fournisseurs')->onDelete('cascade');
            $table->string('codeProformat');
            $table->date('dateProformat');
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
        Schema::dropIfExists('proformats');
    }
}
