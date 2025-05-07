<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HabitacionController extends Controller
{
    public function index()
    {
        return Habitacion::with('hotel')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'tipo' => 'required|in:ESTANDAR,JUNIOR,SUITE',
            'acomodacion' => 'required|in:SENCILLA,DOBLE,TRIPLE,CUÁDRUPLE',
            'cantidad' => 'required|integer|min:1',
        ]);

        $hotel = Hotel::findOrFail($request->hotel_id);

        // Validar combinación tipo-acomodación
        if (!$this->esAcomodacionValida($request->tipo, $request->acomodacion)) {
            return response()->json(['error' => 'La acomodación no es válida para el tipo de habitación.'], 422);
        }

        // Validar que no se repita combinación
        $existe = Habitacion::where('hotel_id', $request->hotel_id)
            ->where('tipo', $request->tipo)
            ->where('acomodacion', $request->acomodacion)
            ->exists();

        if ($existe) {
            return response()->json(['error' => 'Esta combinación de tipo y acomodación ya existe para este hotel.'], 422);
        }

        // Validar que no se exceda el total de habitaciones
        $total_actual = Habitacion::where('hotel_id', $request->hotel_id)->sum('cantidad');
        if ($total_actual + $request->cantidad > $hotel->numero_habitaciones) {
            return response()->json(['error' => 'La cantidad excede el número total de habitaciones permitidas.'], 422);
        }

        return Habitacion::create($request->all());
    }

    public function show(Habitacion $habitacion)
    {
        return $habitacion->load('hotel');
    }

    public function update(Request $request, Habitacion $habitacion)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        $hotel = $habitacion->hotel;
        $suma_otros = Habitacion::where('hotel_id', $habitacion->hotel_id)
            ->where('id', '!=', $habitacion->id)
            ->sum('cantidad');

        if ($suma_otros + $request->cantidad > $hotel->numero_habitaciones) {
            return response()->json(['error' => 'La nueva cantidad excede el límite del hotel.'], 422);
        }

        $habitacion->cantidad = $request->cantidad;
        $habitacion->save();

        return $habitacion;
    }

    public function destroy(Habitacion $habitacion)
    {
        $habitacion->delete();
        return response()->json(['message' => 'Habitación eliminada correctamente.']);
    }

    private function esAcomodacionValida($tipo, $acomodacion)
    {
        $reglas = [
            'ESTANDAR' => ['SENCILLA', 'DOBLE'],
            'JUNIOR' => ['TRIPLE', 'CUÁDRUPLE'],
            'SUITE' => ['SENCILLA', 'DOBLE', 'TRIPLE'],
        ];
        return in_array($acomodacion, $reglas[$tipo]);
    }
}
