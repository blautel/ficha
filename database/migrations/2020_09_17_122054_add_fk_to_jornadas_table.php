<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFkToJornadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jornadas', function (Blueprint $table) {
            $table->foreignId('proyecto_id')->after('user_id')->nullable();
            $table->foreignId('tarea_id')->after('proyecto_id')->nullable();
            $table->foreign(['proyecto_id', 'tarea_id'])->references(['proyecto_id', 'tarea_id'])->on('proyecto_tarea');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jornadas', function (Blueprint $table) {
            $table->dropForeign(['proyecto_id','tarea_id']);
            $table->dropColumn(['proyecto_id','tarea_id']);
        });
    }
}
