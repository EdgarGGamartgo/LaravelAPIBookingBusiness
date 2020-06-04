<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //Liberar tablas desde base si existen
        Schema::dropIfExists('Destino');
        Schema::dropIfExists('Unidad');
        Schema::dropIfExists('TipoUnidad');
           Schema::dropIfExists('Membresia');
           Schema::dropIfExists('Inventario');
           Schema::dropIfExists('Reservacion');
           Schema::dropIfExists('Estancia');
           Schema::dropIfExists('Carrusel');


        //Tabla de gestión de Destinos
        Schema::create('Destino', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->String('nombre', 50);
            $table->String('coordenadas', 50)->nullable();
            $table->timestamps();
        });


        // Insert some Destinations
        DB::table('Destino')
            ->insert(
                array(
                    array(
                        'nombre' => 'Acapulco',
                        'coordenadas' => '91,23'
                    ), array(
                    'nombre' => 'Riviera Maya',
                    'coordenadas' => '91,23'
                ),
                    array(
                        'nombre' => 'Nuevo Vallarta',
                        'coordenadas' => '91,23'
                    )
                )
            );

        //Tabla de gestión de Carrusel
        Schema::create('Unidad', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->String('nombre', 50)->nullable();
            $table->unsignedBigInteger('estatus')->nullable()->default(1);
            $table->timestamps();
        });

        //Tabla de gestión de Tipo de Unidad
        Schema::create('TipoUnidad', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->String('clave', 10)->nullable();
            $table->String('nombre', 50)->nullable();
            $table->decimal('precio_noche', 8, 2)->nullable();
            $table->timestamps();
        });
        // Insert some Destinations
        DB::table('TipoUnidad')
            ->insert(
                array(
                    array(
                        'clave' => 'SGMR',
                        'nombre' => 'Sea Garden - Master Room',
                        'precio_noche' => '0'
                    ),
                    array(
                        'clave' => 'SGST',
                        'nombre' => 'Sea Garden - Master Room',
                        'precio_noche' => '0'
                    ),
                    array(
                        'clave' => 'SGMS',
                        'nombre' => 'Sea Garden - Suite Master',
                        'precio_noche' => '0'
                    ),
                    array(
                        'clave' => 'MPMR',
                        'nombre' => 'Mayan Palace - Master Room',
                        'precio_noche' => '0'
                    ),
                    array(
                        'clave' => 'MPST',
                        'nombre' => 'Mayan Palace - Master Room',
                        'precio_noche' => '0'
                    ),
                    array(
                        'clave' => 'MPMS',
                        'nombre' => 'Mayan Palace - Suite Master',
                        'precio_noche' => '0'
                    )
                )
            );

        //Tabla de gestión de Membresia
        Schema::create('Membresia', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('capacidadAdultos')->nullable();
            $table->unsignedBigInteger('capacidadMenores')->nullable();
            $table->String('ciudad', 50)->nullable();
            $table->String('estado', 50)->nullable();
            $table->String('CP', 50)->nullable();
            $table->String('direccion', 50)->nullable();
            $table->String('telefono', 50)->nullable();
            $table->unsignedBigInteger('user_id_socio');
            $table->timestamp('fechaVigencia')->nullable();
            $table->unsignedBigInteger('id_unidad_maxima');
            $table->timestamps();

            //Relaciones con TipoUnidad
            $table->foreign('id_unidad_maxima')->references('id')->on('TipoUnidad')
                ->onUpdate('cascade')->onDelete('cascade');
            //Relaciones con usuarios
            $table->foreign('user_id_socio')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        //Tabla de gestión de Inventario
        Schema::create('Inventario', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idMembresia');
            $table->unsignedBigInteger('idDestino');
            $table->unsignedBigInteger('idUnidad');
            $table->unsignedBigInteger('idTipoUnidad');
            $table->String('nombreEspacio', 50);
            $table->Text('descripcion');
            $table->Text('queHacer')->nullable();
            $table->Text('amenidades')->nullable();
            $table->Text('comoLlegar')->nullable();
            $table->unsignedBigInteger('estatus')->default(0)->comment("Estatus del inventario 0=No activo, 1=Disponible para venta 2=promocion, 3 = Reservado, 4=Bloqueado");
            $table->timestamps();

            //Relaciones con Membresia
            $table->foreign('idMembresia')->references('id')->on('Membresia')
                ->onUpdate('cascade')->onDelete('cascade');
            //Relaciones con Membresia
            $table->foreign('idDestino')->references('id')->on('Destino')
                ->onUpdate('cascade')->onDelete('cascade');
            //Relaciones con Membresia
            $table->foreign('idUnidad')->references('id')->on('Unidad')
                ->onUpdate('cascade')->onDelete('cascade');
            //Relaciones con Membresia
            $table->foreign('idTipoUnidad')->references('id')->on('TipoUnidad')
                ->onUpdate('cascade')->onDelete('cascade');
            //Relaciones con Membresia
          //  $table->unique('idMembresia', 'idDestino');
        });

        //Tabla de gestión de reservaciones
        Schema::create('Estancia', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->String('nombre_invitado', 50);
            $table->String('apellidos_invitado', 50);
            $table->timestamp('checkin')->nullable();
            $table->timestamp('checkout')->nullable();
            $table->unsignedBigInteger('noches_estancia')->nullable();
            $table->unsignedBigInteger('id_unidad')->nullable();
            $table->decimal('precio_venta', 8, 2)->nullable();
            $table->decimal('precio_compra', 8, 2)->nullable();
            $table->decimal('precio_noche', 8, 2)->nullable();
            $table->unsignedBigInteger('idInventario')->nullable();
            $table->timestamps();
            //relación con Inventario
            //Relaciones con Membresia
            $table->foreign('idInventario')->references('id')->on('Inventario')
                ->onUpdate('cascade')->onDelete('cascade');
            ;
            //Relaciones con usuarios, para saber quien está comprando la estancia
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        //Tabla de gestión de Carrusel
        Schema::create('Carrusel', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->String('nombre', 50)->nullable();
            $table->unsignedBigInteger('estatus')->nullable()->default(1);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('Destino');
       Schema::dropIfExists('Unidad');
             Schema::dropIfExists('TipoUnidad');
             Schema::dropIfExists('Membresia');
             Schema::dropIfExists('Inventario');
       //     Schema::dropIfExists('Reservacion'); //Será eliminada
             Schema::dropIfExists('Estancia');
             Schema::dropIfExists('Carrusel');
    }
}
