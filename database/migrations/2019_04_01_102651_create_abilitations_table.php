<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbilitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abilitations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('users_id')->index()->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('sous_menu_id')->index()->foreign('sous_menu_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('abilitations');
    }
}
