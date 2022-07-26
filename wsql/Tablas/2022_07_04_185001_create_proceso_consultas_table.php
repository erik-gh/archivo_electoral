<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcesoConsultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proceso_consultas', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('id_proceso')
                ->nullable()
                ->constrained('procesos')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('id_consulta')
                ->nullable()
                ->constrained('consultas')
                ->cascadeOnUpdate()
                ->nullOnDelete();
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
        Schema::dropIfExists('proceso_consultas');
    }
}
