<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prestamo extends Model
{
    use SoftDeletes;

    protected $table = 'prestamos';

    protected $casts = [
        'fecha_prestamo' => 'date',
        'fecha_devolucion_esperada' => 'date',
        'fecha_devolucion' => 'date',
    ];

    protected $fillable = [
        'ejemplar_id',
        'user_id',
        'fecha_prestamo',
        'fecha_devolucion_esperada',
        'fecha_devolucion',
    ];

    // Un préstamo pertenece a un ejemplar
    public function ejemplar()
    {
        return $this->belongsTo(Ejemplar::class);
    }

    // Un préstamo pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
