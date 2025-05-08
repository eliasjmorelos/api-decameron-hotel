<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración para crear la tabla 'hotels'.
 *
 * Esta tabla almacena los datos principales de cada hotel,
 * incluyendo nombre, dirección, ciudad, NIT único y número de habitaciones.
 */
return new class extends Migration
{
    /**
     * Ejecuta la migración: crea la tabla 'hotels'.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id(); // Clave primaria
            $table->string('nombre')->unique(); // Nombre único del hotel
            $table->string('direccion');        // Dirección física
            $table->string('ciudad');           // Ciudad donde se ubica
            $table->string('nit')->unique();    // Identificador tributario único
            $table->integer('numero_habitaciones'); // Capacidad máxima en habitaciones
            $table->timestamps();               // created_at y updated_at
        });
    }

    /**
     * Revierte la migración: elimina la tabla 'hotels'.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
