<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informes', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->text('problema');
            $table->text('prueba')->nullable();
            $table->text('conclusion')->nullable();

            $table->unsignedBigInteger('id_activo')->nullable();
            $table->foreign('id_activo')
                     ->references('id')
                     ->on('activos')
                    ->onDelete('set null');
            
            $table->unsignedBigInteger('id_persona')->nullable();
            $table->foreign('id_persona')
                     ->references('id')
                     ->on('personas')
                    ->onDelete('set null');

            
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
        Schema::dropIfExists('informes');
    }
}
