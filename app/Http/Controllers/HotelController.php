<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Controlador para gestionar hoteles.
 * Incluye operaciones CRUD y carga de relaciones con habitaciones.
 */
class HotelController extends Controller
{
    /**
     * Retorna una lista de todos los hoteles con sus habitaciones asociadas.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Hotel::with('habitaciones')->get();
    }

    /**
     * Crea un nuevo hotel después de validar los datos de entrada.
     * Valida nombre único, NIT único y número mínimo de habitaciones.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\Hotel
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|unique:hotels,nombre',
            'direccion' => 'required|string',
            'ciudad' => 'required|string',
            'nit' => 'required|string|unique:hotels,nit',
            'numero_habitaciones' => 'required|integer|min:1',
        ]);

        return Hotel::create($validated);
    }

    /**
     * Muestra un hotel específico junto con sus habitaciones asociadas.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function show(Hotel $hotel)
    {
        return $hotel->load('habitaciones');
    }

    /**
     * Actualiza los datos de un hotel existente, aplicando validación de unicidad condicional.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hotel  $hotel
     * @return \App\Models\Hotel
     */
    public function update(Request $request, Hotel $hotel)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', Rule::unique('hotels')->ignore($hotel->id)],
            'direccion' => 'required|string',
            'ciudad' => 'required|string',
            'nit' => ['required', 'string', Rule::unique('hotels')->ignore($hotel->id)],
            'numero_habitaciones' => 'required|integer|min:1',
        ]);

        $hotel->update($validated);
        return $hotel;
    }

    /**
     * Elimina un hotel y sus habitaciones asociadas (por cascada si está definido).
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return response()->json(['message' => 'Hotel eliminado correctamente.']);
    }
}
