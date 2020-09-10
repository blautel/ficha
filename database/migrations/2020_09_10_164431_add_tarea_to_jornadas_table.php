<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTareaToJornadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jornadas', function (Blueprint $table) {
            if (!Schema::hasColumn('jornadas', 'tarea_id')) {
                $table->unsignedBigInteger('tarea_id')->index()->after('user_id')->nullable();
                $table->foreign('tarea_id')->references('tarea_id')->on('proyecto_tarea');
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
        if (Schema::hasColumn('jornadas', 'tarea_id')) {
            Schema::table('jornadas', function (Blueprint $table) {
                $table->dropForeign(['tarea_id']);
                $table->dropColumn('tarea_id');
            });
        }
    }
}
