<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHabilitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habilitations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_id')->index()->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('sous_menus_id')->index()->foreign('sous_menus_id')->references('id')->on('sous_menus')->onDelete('cascade');
            $table->string('slug');
            $table->integer('etat');
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
        Schema::dropIfExists('habilitations');
    }
}
