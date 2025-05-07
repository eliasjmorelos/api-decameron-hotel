<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HotelController extends Controller
{
    public function index()
    {
        return Hotel::with('habitaciones')->get();
    }

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

    public function show(Hotel $hotel)
    {
        return $hotel->load('habitaciones');
    }

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

    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        return response()->json(['message' => 'Hotel eliminado correctamente.']);
    }
}
