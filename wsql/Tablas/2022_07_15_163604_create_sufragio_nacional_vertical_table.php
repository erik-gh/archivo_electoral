<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSufragioNacionalVerticalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sufragio_nacional_vertical', function (Blueprint $table) {
            $table->string('COD_PROCESO',15)->nullable();
            $table->integer('COD_ODPE')->nullable();
            $table->string('COD_UBI',6)->nullable();
            $table->string('DEPAR_UBI',255)->nullable();
            $table->string('PROV_UBI',255)->nullable();
            $table->string('DIST_UBI',255)->nullable();
            $table->string('COD_LOC',8)->nullable();
            $table->string('NOM_LOC',255)->nullable();
            $table->string('DIR_LOC',255)->nullable();
            $table->string('NRO_MESA',255)->nullable();
            $table->string('N_MESA_MADRE',255)->nullable();
            $table->string('ELECTORES',255)->nullable();
            $table->string('CONDI',2)->nullable();
            $table->string('ORDEN',255)->nullable();
            $table->integer('TOTELECMMADRE')->nullable();
            $table->string('COD_CONSULTA',10)->nullable();
            $table->string('COD_ST',5)->nullable();
            $table->string('ESPECIAL',5)->nullable();
            $table->string('COD_LOC_NUEVO',20)->nullable();
            $table->string('NOM_ODPE',255)->nullable();
            $table->string('COD_PP',4)->nullable();
            $table->string('COD_TIPO',3)->nullable();
            $table->string('COD_AC',3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sufragio_nacional_vertical');
    }
}
