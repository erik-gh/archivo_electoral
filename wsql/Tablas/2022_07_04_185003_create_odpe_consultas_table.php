<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdpeConsultasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('odpe_consultas', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId('id_odpe')
                ->nullable()
                ->constrained('odpes')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('id_consulta')
                ->nullable()
                ->constrained('consultas')
                ->cascadeOnUpdate()
                ->nullOnDelete();
            $table->foreignId('id_proceso')
                ->nullable()
                ->constrained('procesos')
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
        Schema::dropIfExists('odpe_consultas');
    }
}
