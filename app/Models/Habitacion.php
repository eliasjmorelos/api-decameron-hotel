<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Eloquent que representa una habitación dentro de un hotel.
 *
 * Cada habitación está relacionada con un hotel y contiene información
 * sobre su tipo, acomodación y cantidad disponible.
 *
 * @property int $id
 * @property int $hotel_id
 * @property string $tipo
 * @property string $acomodacion
 * @property int $cantidad
 * @property \App\Models\Hotel $hotel
 */
class Habitacion extends Model
{
    use HasFactory;

    /**
     * Atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'hotel_id',
        'tipo',
        'acomodacion',
        'cantidad',
    ];

    /**
     * Relación: una habitación pertenece a un hotel.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
}
