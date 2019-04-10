<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocieteServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('societe_services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('societes_id')->index()->foreign('societes_id')->references('id')->on('societes')->onDelete('cascade');
            $table->integer('services_id')->index()->foreign('services_id')->references('id')->on('services')->onDelete('cascade');
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
        Schema::dropIfExists('societe_services');
    }
}
