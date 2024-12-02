<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProcedimientoAndPersonalToIncidencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('incidencias', function (Blueprint $table) {
            // Agregar el campo 'procedimiento' como texto (campo largo)
            $table->text('procedimiento')->nullable(); // Usamos text() si es más largo que 255 caracteres

            // Agregar el campo 'id_personal' que hace referencia al ID de la tabla 'personas'
            $table->unsignedBigInteger('id_personal')->nullable(); // Definimos como unsignedBigInteger para la relación
            $table->foreign('id_personal')->references('id')->on('personas')->onDelete('set null'); // Relación con la tabla 'personas'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('incidencias', function (Blueprint $table) {
            // Eliminar los campos agregados en caso de revertir la migración
            $table->dropForeign(['id_personal']); // Eliminar la clave foránea
            $table->dropColumn('id_personal'); // Eliminar la columna 'id_personal'
            $table->dropColumn('procedimiento'); // Eliminar la columna 'procedimiento'
        });
    }
}
