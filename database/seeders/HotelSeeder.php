<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\Habitacion;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        $hotel = Hotel::create([
            'nombre' => 'Decameron Cartagena',
            'direccion' => 'Calle 23 58-25',
            'ciudad' => 'Cartagena',
            'nit' => '12345678-9',
            'numero_habitaciones' => 42,
        ]);

        $habitaciones = [
            ['tipo' => 'ESTANDAR', 'acomodacion' => 'SENCILLA', 'cantidad' => 25],
            ['tipo' => 'JUNIOR', 'acomodacion' => 'TRIPLE', 'cantidad' => 12],
            ['tipo' => 'ESTANDAR', 'acomodacion' => 'DOBLE', 'cantidad' => 5],
        ];

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
