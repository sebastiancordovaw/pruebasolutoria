<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicador', function (Blueprint $table) {
            $table->id();
            $table->string('nombreIndicador',255);
            $table->string('codigoIndicador',255);
            $table->string('unidadMedidaIndicador',100);
            $table->double('valorIndicador', 8, 2);
            $table->date('fechaIndicador');
            $table->dateTime('tiempoIndicador')->nullable();
            $table->string('origenIndicador',255);
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
        Schema::dropIfExists('indicador');
    }
};
