<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración para crear la tabla 'habitacions'.
 *
 * Esta tabla almacena la configuración de habitaciones asociadas a hoteles,
 * incluyendo tipo, acomodación, cantidad y su relación con la tabla 'hotels'.
 */
return new class extends Migration
{
    /**
     * Ejecuta la migración: crea la tabla 'habitacions'.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('habitacions', function (Blueprint $table) {
            $table->id(); // Clave primaria

            // Llave foránea que referencia a la tabla 'hotels'
            $table->foreignId('hotel_id')->constrained()->onDelete('cascade');

            // Tipo de habitación
            $table->enum('tipo', ['ESTANDAR', 'JUNIOR', 'SUITE']);

            // Acomodación permitida
            $table->enum('acomodacion', ['SENCILLA', 'DOBLE', 'TRIPLE', 'CUÁDRUPLE']);

            // Número de habitaciones de ese tipo
            $table->integer('cantidad');

            $table->timestamps(); // created_at y updated_at

            // Restricción de unicidad: una misma combinación no se puede repetir por hotel
            $table->unique(['hotel_id', 'tipo', 'acomodacion']);
        });
    }

    /**
     * Revierte la migración: elimina la tabla 'habitacions'.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('habitacions');
    }
};
