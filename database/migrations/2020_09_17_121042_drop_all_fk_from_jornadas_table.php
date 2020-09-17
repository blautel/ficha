<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropAllFkFromJornadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('jornadas', 'tarea_id')) {
            Schema::table('jornadas', function (Blueprint $table) {
                $table->dropForeign(['tarea_id']);
                $table->dropColumn('tarea_id');
            });
        }
        if (Schema::hasColumn('jornadas', 'proyecto_id')) {
            Schema::table('jornadas', function (Blueprint $table) {
                $table->dropForeign(['proyecto_id']);
                $table->dropColumn('proyecto_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jornadas', function (Blueprint $table) {
            if (!Schema::hasColumn('jornadas', 'tarea_id')) {
                $table->foreign('tarea_id')->references('tarea_id')->on('proyecto_tarea');
            }
            if (!Schema::hasColumn('jornadas', 'proyecto_id')) {
                $table->foreign('proyecto_id')->references('proyecto_id')->on('proyecto_tarea');
            }
        });
    }
}
