<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Eloquent que representa un hotel en el sistema.
 *
 * Un hotel puede tener múltiples habitaciones asociadas y contiene información
 * básica como su nombre, dirección, ciudad, NIT y número total de habitaciones.
 *
 * @property int $id
 * @property string $nombre
 * @property string $direccion
 * @property string $ciudad
 * @property string $nit
 * @property int $numero_habitaciones
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Habitacion[] $habitaciones
 */
class Hotel extends Model
{
    use HasFactory;

    /**
     * Atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'direccion',
        'ciudad',
        'nit',
        'numero_habitaciones',
    ];

    /**
     * Relación: un hotel tiene muchas habitaciones.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function habitaciones()
    {
        return $this->hasMany(Habitacion::class);
    }
}
