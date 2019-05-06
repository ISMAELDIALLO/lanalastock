<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('fournisseurs_id')->index()->foreign('fournisseurs_id')->references('id')->on('fournisseurs')->onDelete('cascade');
            $table->integer('cotations_id')->nullable()->index()->foreign('cotations_id')->references('id')->on('cotations')->onDelete('cascade');
            $table->integer('users_id')->index()->foreign('users_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('codeCommande');
            $table->date('dateCommande');
            $table->integer('etat')->nullable();
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
        Schema::dropIfExists('commandes');
    }
}
