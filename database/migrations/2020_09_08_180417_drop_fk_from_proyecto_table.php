<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropFkFromProyectoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('tareas', 'id_proyecto')) {
            Schema::table('tareas', function (Blueprint $table) {
                $table->dropForeign(['id_proyecto']);
                $table->dropColumn('id_proyecto');
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
        Schema::table('tareas', function (Blueprint $table) {
            if (!Schema::hasColumn('tareas', 'id_proyecto')) {
                $table->unsignedBigInteger('id_proyecto')->after('id')->nullable();
                $table->foreign('id_proyecto')->references('id')->on('proyectos');
            }
        });
    }
}
