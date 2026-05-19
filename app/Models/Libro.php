<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Libro extends Model
{
    use SoftDeletes;

    protected $table = 'libros';

    protected $casts = [
        'imagenes' => 'array',
        'fecha_publicacion' => 'date:Y-m-d',
    ];

    protected $fillable = [
        'titulo',
        'autor',
        'editorial',
        'imagenes',
        'fecha_publicacion',
    ];

    // Un libro tiene muchos ejemplares
    public function ejemplares()
    {
        return $this->hasMany(Ejemplar::class);
    }

    // Un libro pertenece a muchas categorías
    public function categorias()
    {
        return $this->belongsToMany(Categoria::class);
    }
}
