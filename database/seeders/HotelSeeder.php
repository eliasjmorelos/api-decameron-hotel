<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\Habitacion;

/**
 * Seeder para poblar la base de datos con un hotel de ejemplo y sus habitaciones.
 * 
 * Crea el hotel de ejemplo llamado "Decameron Cartagena" y le asigna las habitaciones del ejemplo
 * con tipos y acomodaciones específicas.
 */
class HotelSeeder extends Seeder
{
    /**
     * Ejecuta el seeder para insertar datos de prueba en las tablas 'hotels' y 'habitacions'.
     *
     * @return void
     */
    public function run(): void
    {
        // Crea el hotel principal
        $hotel = Hotel::create([
            'nombre' => 'Decameron Cartagena',
            'direccion' => 'Calle 23 58-25',
            'ciudad' => 'Cartagena',
            'nit' => '12345678-9',
            'numero_habitaciones' => 42,
        ]);

        // Definición de habitaciones para el hotel creado
        $habitaciones = [
            ['tipo' => 'ESTANDAR', 'acomodacion' => 'SENCILLA', 'cantidad' => 25],
            ['tipo' => 'JUNIOR', 'acomodacion' => 'TRIPLE', 'cantidad' => 12],
            ['tipo' => 'ESTANDAR', 'acomodacion' => 'DOBLE', 'cantidad' => 5],
        ];

        // Crea cada habitación y asociarla al hotel
        foreach ($habitaciones as $hab) {
            Habitacion::create([
                'hotel_id' => $hotel->id,
                'tipo' => $hab['tipo'],
                'acomodacion' => $hab['acomodacion'],
                'cantidad' => $hab['cantidad'],
            ]);
        }
    }
}
