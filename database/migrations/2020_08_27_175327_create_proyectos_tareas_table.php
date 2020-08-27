<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProyectosTareasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectos_tareas', function (Blueprint $table) {
            $table->unsignedBigInteger('id_tarea');
            $table->unsignedBigInteger('id_proyecto');
            $table->foreign('id_tarea')->references('id')->on('tareas');
            $table->foreign('id_proyecto')->references('id')->on('proyectos');
            $table->timestamps();
            $table->primary(['id_tarea', 'id_proyecto']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proyectos_tareas');
    }
}
