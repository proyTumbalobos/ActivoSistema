<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();


            $table->unsignedBigInteger('id_sede')->nullable();
            $table->foreign('id_sede')
                     ->references('id')
                     ->on('sedes')
                    ->onDelete('set null');

            $table->unsignedBigInteger('id_area')->nullable();
            $table->foreign('id_area')
                    ->references('id')
                    ->on('areas')
                    ->onDelete('set null');

            $table->string('nombre');
            
            $table->string('detalle', 100);
            $table->date('fecha_ingreso');
            $table->date('fecha_termino')->nullable();
            $table->string('estado', 20); // abierto, en proceso, cerrado
            //$table->binary('imagen')->nullable(); // Cambiado a binary para almacenar imágenes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidencias');
    }
}
