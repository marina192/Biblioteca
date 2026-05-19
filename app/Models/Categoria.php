<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categoria extends Model
{
    use SoftDeletes;

    protected $table = 'categorias';

    protected $casts = [
        'imagenes' => 'array',
    ];

    protected $fillable = [
        'nombre',
        'imagenes',
        'descripcion',
    ];

    // Una categoría pertenece a muchos libros
    public function libros()
    {
        return $this->belongsToMany(Libro::class);
    }
}
