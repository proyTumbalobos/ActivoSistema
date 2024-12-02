<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('TipoPersona')->constrained('tipo_persona', 'IdTipo');
            

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
            
            $table->char('dni', 8);
            $table->boolean('estado'); // 0 (activo), 1 (no activo)
            $table->string('nombre', 100);
            $table->string('apellido', 100);
            
            $table->string('contraseña');
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
        Schema::dropIfExists('personas');
    }
}
