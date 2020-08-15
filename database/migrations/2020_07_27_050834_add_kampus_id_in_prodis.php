<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKampusIdInProdis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prodis', function (Blueprint $table) {
            $table->bigInteger('kampus_id')->unsigned();
            $table->foreign('kampus_id')->references('id')->on('kampuses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prodis', function (Blueprint $table) {
            //
        });
    }
}
