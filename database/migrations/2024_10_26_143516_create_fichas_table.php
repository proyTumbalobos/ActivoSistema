<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fichas', function (Blueprint $table) {
            $table->id();

            

            $table->unsignedBigInteger('id_persona')->nullable();
            $table->foreign('id_persona')
                     ->references('id')
                     ->on('personas')
                    ->onDelete('set null');

            $table->unsignedBigInteger('id_tipo')->nullable();
            $table->foreign('id_tipo')
                    ->references('id')
                    ->on('tipo_fichas')
                    ->onDelete('set null');

            $table->text('detalle');
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
        Schema::dropIfExists('fichas');
    }
}
