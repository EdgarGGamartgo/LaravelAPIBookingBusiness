<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExtrasToInventario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Inventario', function (Blueprint $table) {
           // $table->String('maxAdults', 50);
            $table->integer('maxAdults');
            $table->integer('maxKids');
            $table->integer('maxRooms');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Inventario', function (Blueprint $table) {
            //
        });
    }
}
