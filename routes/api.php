<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\HabitacionController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Rutas de hoteles
Route::prefix('hoteles')->group(function () {
    Route::get('/', [HotelController::class, 'index']);           // Listar todos los hoteles
    Route::post('/', [HotelController::class, 'store']);          // Crear hotel
    Route::get('{hotel}', [HotelController::class, 'show']);      // Ver detalles de un hotel
    Route::put('{hotel}', [HotelController::class, 'update']);    // Actualizar hotel
    Route::delete('{hotel}', [HotelController::class, 'destroy']); // Eliminar hotel
});

// Rutas de habitaciones
Route::prefix('habitaciones')->group(function () {
    Route::get('/', [HabitacionController::class, 'index']);          // Listar todas las habitaciones
    Route::post('/', [HabitacionController::class, 'store']);         // Crear habitación con validaciones
    Route::get('{habitacion}', [HabitacionController::class, 'show']); // Ver una habitación
    Route::put('{habitacion}', [HabitacionController::class, 'update']); // Actualizar solo la cantidad
    Route::delete('{habitacion}', [HabitacionController::class, 'destroy']); // Eliminar habitación
});
