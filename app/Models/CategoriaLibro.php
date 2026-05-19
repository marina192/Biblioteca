<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaLibro extends Model
{
    protected $table = 'categoria_libro';

    protected $fillable = [
        'libro_id',
        'categoria_id',
    ];
}
