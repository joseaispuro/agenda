<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('concepto');
            $table->string('asunto');
            $table->dateTime('fecha_inicio', 0);
            $table->dateTime('fecha_fin', 0);
            $table->string('tipo_cita');
            $table->string('lugar');
            $table->boolean('atiende_alcalde');
            $table->string('atiende');
            $table->string('asiste');
            $table->string('contacto');
            $table->boolean('publicada')->default(0);
            $table->string('observaciones')->nullable();
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
        Schema::dropIfExists('eventos');
    }
}
