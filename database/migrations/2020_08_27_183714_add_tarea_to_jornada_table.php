<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTareaToJornadaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jornadas', function (Blueprint $table) {
            if (!Schema::hasColumn('jornadas', 'id_tarea')) {
                $table->unsignedBigInteger('id_tarea')->index()->after('user_id');
                $table->foreign('id_tarea')->references('id_tarea')->on('proyectos_tareas');
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
        if (Schema::hasColumn('jornadas', 'id_tarea')) {
            Schema::table('jornadas', function (Blueprint $table) {
                $table->dropForeign(['id_tarea']);
                $table->dropColumn('id_tarea');
            });
        }
    }
}
