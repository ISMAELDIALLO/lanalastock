<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSortieStocksIdToDetailSortieStsocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detail_sortie_stocks', function (Blueprint $table) {
            $table->integer('sortie_stocks_id')->index()->foreign('sortie_stocks_id')->references('id')->on('sortie_stocks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detail_sortie_stocks', function (Blueprint $table) {
            $table->dropColumn('sortie_stocks_id');
        });
    }
}
