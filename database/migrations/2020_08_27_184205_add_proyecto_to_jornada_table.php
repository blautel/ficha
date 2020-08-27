<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProyectoToJornadaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jornadas', function (Blueprint $table) {
            if (!Schema::hasColumn('jornadas', 'id_proyecto')) {
                $table->unsignedBigInteger('id_proyecto')->index()->after('id_tarea');
                $table->foreign('id_proyecto')->references('id_proyecto')->on('proyectos_tareas');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('jornadas', 'id_proyecto')) {
            Schema::table('jornadas', function (Blueprint $table) {
                $table->dropForeign(['id_proyecto']);
                $table->dropColumn('id_proyecto');
            });
        }
    }
}
