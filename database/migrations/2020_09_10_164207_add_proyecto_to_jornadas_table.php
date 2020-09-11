<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProyectoToJornadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jornadas', function (Blueprint $table) {
            if (!Schema::hasColumn('jornadas', 'proyecto_id')) {
                $table->unsignedBigInteger('proyecto_id')->index()->after('user_id')->nullable();
                $table->foreign('proyecto_id')->references('proyecto_id')->on('proyecto_tarea');
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
        if (Schema::hasColumn('jornadas', 'proyecto_id')) {
            Schema::table('jornadas', function (Blueprint $table) {
                $table->dropForeign(['proyecto_id']);
                $table->dropColumn('proyecto_id');
            });
        }
    }
}
