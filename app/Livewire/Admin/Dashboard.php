<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Ejemplar;
use App\Models\Prestamo;

class Dashboard extends Component
{
    public function render()
    {
        $ejemplares = Ejemplar::where('estado', '!=', 'perdido')
            ->count();

        $prestamosActivos = Prestamo::whereNull('fecha_devolucion')
            ->where('fecha_devolucion_esperada', '>=', now())
            ->whereHas('ejemplar')
            ->count();

        $bibliotecarios = User::role('admin')->count();

        $prestamosVencidos = Prestamo::whereNull('fecha_devolucion')
            ->where('fecha_devolucion_esperada', '<', now())
            ->whereHas('ejemplar')
            ->count();

        $mesesEs = [
            1=>'Enero', 2=>'Febrero', 3=>'Marzo', 4=>'Abril',
            5=>'Mayo', 6=>'Junio', 7=>'Julio', 8=>'Agosto',
            9=>'Septiembre', 10=>'Octubre', 11=>'Noviembre', 12=>'Diciembre'
        ];

        $prestamosPorMes = Prestamo::selectRaw('MONTH(fecha_prestamo) as num_mes, COUNT(*) as total')
            ->whereYear('fecha_prestamo', date('Y'))
            ->groupBy('num_mes')
            ->orderBy('num_mes')
            ->get()
            ->map(fn($r) => ['mes' => $mesesEs[$r->num_mes], 'total' => $r->total]);

        $prestamosDevueltosPorMes = Prestamo::selectRaw('MONTH(fecha_prestamo) as num_mes, COUNT(*) as total')
            ->whereYear('fecha_prestamo', date('Y'))
            ->whereNotNull('fecha_devolucion')
            ->groupBy('num_mes')
            ->orderBy('num_mes')
            ->get()
            ->map(fn($r) => ['mes' => $mesesEs[$r->num_mes], 'total' => $r->total]);

        $librosMasLeidos = Prestamo::selectRaw('libros.titulo, COUNT(*) as total')
            ->join('ejemplares', 'prestamos.ejemplar_id', '=', 'ejemplares.id')
            ->join('libros', 'ejemplares.libro_id', '=', 'libros.id')
            ->groupBy('libros.titulo')
            ->orderByDesc('total')
            ->take(3)
            ->pluck('total', 'libros.titulo');


        return view('livewire.admin.dashboard', [
            'prestamosPorMes' => $prestamosPorMes,
            'prestamosDevueltosPorMes' => $prestamosDevueltosPorMes,
            'librosMasLeidos' => $librosMasLeidos,
            'ejemplares' => $ejemplares,
            'prestamosActivos' => $prestamosActivos,
            'bibliotecarios' => $bibliotecarios,
            'prestamosVencidos' => $prestamosVencidos,
        ])->layout('layouts.app_administrador');
    }
}