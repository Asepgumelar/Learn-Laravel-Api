<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProdiIdInMatkuls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('matkuls', function (Blueprint $table) {
            $table->bigInteger('prodi_id')->unsigned();
            $table->foreign('prodi_id')->references('id')->on('prodis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('matkuls', function (Blueprint $table) {
            //
        });
    }
}
