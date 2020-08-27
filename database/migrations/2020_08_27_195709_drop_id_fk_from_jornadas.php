<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropIdFkFromJornadas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('jornadas', 'id_proyecto')) {
            Schema::table('jornadas', function (Blueprint $table) {
                $table->dropForeign(['id_proyecto']);
                $table->dropColumn('id_proyecto');
            });
        }
        if (Schema::hasColumn('jornadas', 'id_tarea')) {
            Schema::table('jornadas', function (Blueprint $table) {
                $table->dropForeign(['id_tarea']);
                $table->dropColumn('id_tarea');
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
            //
        });
    }
}
