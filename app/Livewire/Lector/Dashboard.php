<?php

namespace App\Livewire\Lector;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Categoria;
use App\Models\Libro;
use App\Models\Prestamo;

class Dashboard extends Component
{
    public function render()
    {
        $anioActual = date('Y');

        $librosMasLeidos = Prestamo::selectRaw('libros.titulo, COUNT(*) as total')
            ->join('ejemplares', 'prestamos.ejemplar_id', '=', 'ejemplares.id')
            ->join('libros', 'ejemplares.libro_id', '=', 'libros.id')
            ->whereYear('prestamos.fecha_prestamo', $anioActual)
            ->groupBy('libros.titulo')
            ->orderByDesc('total')
            ->take(5)
            ->pluck('total', 'libros.titulo');

        $categoriasMasPopulares = Prestamo::selectRaw('categorias.nombre, COUNT(*) as total')
            ->join('ejemplares', 'prestamos.ejemplar_id', '=', 'ejemplares.id')
            ->join('libros', 'ejemplares.libro_id', '=', 'libros.id')
            ->join('categoria_libro', 'libros.id', '=', 'categoria_libro.libro_id')
            ->join('categorias', 'categoria_libro.categoria_id', '=', 'categorias.id')
            ->whereYear('prestamos.fecha_prestamo', $anioActual)
            ->groupBy('categorias.nombre')
            ->orderByDesc('total')
            ->take(5)
            ->pluck('total', 'categorias.nombre');

        $misPrestamosActivos = Prestamo::where('user_id', Auth::id())
            ->whereNull('fecha_devolucion')
            ->whereHas('ejemplar')
            ->count();

        $librosLeidos = Prestamo::where('user_id', Auth::id())
            ->whereNotNull('fecha_devolucion')
            ->count();

        $totalLibros = Libro::count();
        $totalCategorias = Categoria::count();

        return view('livewire.lector.dashboard', [
            'librosMasLeidos'        => $librosMasLeidos,
            'categoriasMasPopulares' => $categoriasMasPopulares,
            'misPrestamosActivos'    => $misPrestamosActivos,
            'librosLeidos'           => $librosLeidos,
            'totalLibros'            => $totalLibros,
            'totalCategorias'        => $totalCategorias,
            'prestamosActivos'       => $misPrestamosActivos,
        ])->layout('layouts.app_lector');
    }
}