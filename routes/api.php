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
| Aquí se registran todas las rutas API para la aplicación.
| Estas rutas están agrupadas por recursos RESTful y utilizan controladores
| dedicados para hoteles y habitaciones.
|
*/

/*
|--------------------------------------------------------------------------
| Rutas REST: Hoteles
|--------------------------------------------------------------------------
|
| Estas rutas manejan la creación, visualización, edición y eliminación
| de hoteles en el sistema.
|
*/
Route::prefix('hoteles')->group(function () {
    Route::get('/', [HotelController::class, 'index']);            // Listar todos los hoteles
    Route::post('/', [HotelController::class, 'store']);           // Crear un nuevo hotel
    Route::get('{hotel}', [HotelController::class, 'show']);       // Ver un hotel específico
    Route::put('{hotel}', [HotelController::class, 'update']);     // Actualizar los datos de un hotel
    Route::delete('{hotel}', [HotelController::class, 'destroy']); // Eliminar un hotel
});

/*
|--------------------------------------------------------------------------
| Rutas REST: Habitaciones
|--------------------------------------------------------------------------
|
| Estas rutas gestionan la creación, visualización, edición y eliminación
| de habitaciones asociadas a hoteles.
|
*/
Route::prefix('habitaciones')->group(function () {
    Route::get('/', [HabitacionController::class, 'index']);            // Listar todas las habitaciones
    Route::post('/', [HabitacionController::class, 'store']);           // Crear una nueva habitación
    Route::get('{habitacion}', [HabitacionController::class, 'show']); // Ver una habitación específica
    Route::put('{habitacion}', [HabitacionController::class, 'update']); // Actualizar la cantidad de una habitación
    Route::delete('{habitacion}', [HabitacionController::class, 'destroy']); // Eliminar una habitación
});
