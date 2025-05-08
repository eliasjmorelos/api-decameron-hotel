<?php

namespace App\Http\Controllers;

use App\Models\Habitacion;
use App\Models\Hotel;
use Illuminate\Http\Request;

/**
 * Controlador para gestionar habitaciones de hoteles.
 * Incluye operaciones CRUD y validaciones de negocio específicas.
 */
class HabitacionController extends Controller
{
    /**
     * Devuelve una lista de todas las habitaciones con su hotel asociado.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Habitacion::with('hotel')->get();
    }

    /**
     * Crea una nueva habitación, aplicando validaciones de reglas de negocio:
     * - Acomodación válida según tipo
     * - No duplicidad por combinación tipo+acomodación
     * - No superar límite de habitaciones por hotel
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse|\App\Models\Habitacion
     */
    public function store(Request $request)
    {
        $request->validate([
            'hotel_id' => 'required|exists:hotels,id',
            'tipo' => 'required|in:ESTANDAR,JUNIOR,SUITE',
            'acomodacion' => 'required|in:SENCILLA,DOBLE,TRIPLE,CUÁDRUPLE',
            'cantidad' => 'required|integer|min:1',
        ]);

        $hotel = Hotel::findOrFail($request->hotel_id);

        if (!$this->esAcomodacionValida($request->tipo, $request->acomodacion)) {
            return response()->json(['error' => 'La acomodación no es válida para el tipo de habitación.'], 422);
        }

        $existe = Habitacion::where('hotel_id', $request->hotel_id)
            ->where('tipo', $request->tipo)
            ->where('acomodacion', $request->acomodacion)
            ->exists();

        if ($existe) {
            return response()->json(['error' => 'Esta combinación de tipo y acomodación ya existe para este hotel.'], 422);
        }

        $total_actual = Habitacion::where('hotel_id', $request->hotel_id)->sum('cantidad');
        if ($total_actual + $request->cantidad > $hotel->numero_habitaciones) {
            return response()->json(['error' => 'La cantidad excede el número total de habitaciones permitidas.'], 422);
        }

        return Habitacion::create($request->all());
    }

    /**
     * Muestra los datos de una habitación específica con su hotel.
     *
     * @param  \App\Models\Habitacion  $habitacion
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function show(Habitacion $habitacion)
    {
        return $habitacion->load('hotel');
    }

    /**
     * Actualiza únicamente la cantidad de una habitación existente,
     * validando que no se exceda el total permitido por el hotel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Habitacion  $habitacion
     * @return \Illuminate\Http\JsonResponse|\App\Models\Habitacion
     */
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

    /**
     * Elimina una habitación del sistema.
     *
     * @param  \App\Models\Habitacion  $habitacion
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Habitacion $habitacion)
    {
        $habitacion->delete();
        return response()->json(['message' => 'Habitación eliminada correctamente.']);
    }

    /**
     * Verifica si la acomodación es válida para un tipo de habitación.
     *
     * @param  string  $tipo
     * @param  string  $acomodacion
     * @return bool
     */
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
