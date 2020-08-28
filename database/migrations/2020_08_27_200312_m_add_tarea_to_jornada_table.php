<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MAddTareaToJornadaTable extends Migration
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
                $table->unsignedBigInteger('id_tarea')->after('user_id')->nullable();
                $table->foreign('id_tarea')->references('id')->on('tareas');
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
