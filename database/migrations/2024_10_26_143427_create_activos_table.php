<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activos', function (Blueprint $table) {
            $table->id();
            //$table->foreignId('id_categoria')->constrained('categoria_activo', 'id');
            $table->unsignedBigInteger('id_categoria')->nullable();
            $table->foreign('id_categoria')
                     ->references('id')
                     ->on('categoria_activos')
                    ->onDelete('set null');
            //$table->foreignId('IdPersona')->nullable()->constrained('persona', 'IDPersona'); // Puede ser nulo
            $table->string('fabricante', 50);
            $table->string('serie', 50);
            $table->string('modelo', 50);

            $table->string('n_orden');
            $table->decimal('valor',10,2);
            
            $table->string('ip', 20)->nullable();
            $table->string('color', 50)->nullable();
            $table->string('estado', 20); // operativo, no operativo, mantenimiento
            $table->date('fechacompra');
            //$table->double('valorcompra');
            //$table->string('ordencompra', 50)->nullable();
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
        Schema::dropIfExists('activos');
    }
}
