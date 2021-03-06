<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('nomSuperieur')->nullable();
            $table->string('emailSuperieur')->nullable();
            $table->string('role');
            $table->integer('services_id')->nullable()->index()->foreign('services_id')->references('id')->on('services')->onDelete('cascade');
            $table->string('password');
            $table->string('confirm_mot_de_passe');
            $table->string('slug');
            $table->integer('statut');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
