<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSolicitudTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Solicitud', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('destino');
            $table->string('extras');
            $table->string('checkIn');
            $table->string('checkOut');
            $table->string('guests');
            $table->string('rooms');
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
        Schema::dropIfExists('Solicitud');
    }
}
