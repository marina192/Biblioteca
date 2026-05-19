<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ejemplar extends Model
{
    use SoftDeletes;

    protected $table = 'ejemplares';

    protected $fillable = [
        'libro_id',
        'codigo_unico',
        'estado',
        'ubicacion',
        'nombre',
    ];

    // Un ejemplar pertenece a un libro
    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }

    // Un ejemplar puede tener muchos préstamos
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }
}
