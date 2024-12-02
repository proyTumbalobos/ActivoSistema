<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdTipoPersonaToPersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personas', function (Blueprint $table) {
            // Agregar la columna idTipoPersona como una clave foránea
            $table->unsignedBigInteger('idTipoPersona')->nullable();

            // Establecer la clave foránea con la tabla tipo_personas
            $table->foreign('idTipoPersona')
                  ->references('id')
                  ->on('tipo_personas')
                  ->onDelete('set null');  // Esto garantiza que si un tipo de persona se elimina, se establece a null en la tabla personas.
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personas', function (Blueprint $table) {
            // Eliminar la clave foránea y la columna si se deshace la migración
            $table->dropForeign(['idTipoPersona']);
            $table->dropColumn('idTipoPersona');
        });
    }
}
