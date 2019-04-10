<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSousMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sous_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('menus_id')->index()->foreign('menus_id')->references('id')->on('menus')->onDelete('cascade');
            $table->string('nomSousMenu');
            $table->string('lien');
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
        Schema::dropIfExists('sous_menus');
    }
}
