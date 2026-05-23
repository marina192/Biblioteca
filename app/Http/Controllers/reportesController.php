<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prestamo;

class reportesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $libro     = $request->input('libro');
        $libroId   = $request->input('libro_id');
        $usuario   = $request->input('usuario');
        $usuarioId = $request->input('usuario_id');
        $fechaPrestamoInicio = $request->input('fecha_prestamo_inicio');
        $fechaPrestamoFin = $request->input('fecha_prestamo_fin');
        $fechaDevolutionInicio = $request->input('fecha_devolucion_inicio');
        $fechaDevolutionFin = $request->input('fecha_devolucion_fin');

        $aplicarFiltros = function ($query) use ($libro, $libroId, $usuario, $usuarioId, $fechaPrestamoInicio, $fechaPrestamoFin, $fechaDevolutionInicio, $fechaDevolutionFin) {
            $query
                ->when($libro, fn($q) =>
                    $q->whereHas('ejemplar.libro', fn($q2) =>
                        $q2->where('titulo', 'like', "%{$libro}%")
                    )
                )
                ->when($libroId, fn($q) =>
                    $q->whereHas('ejemplar.libro', fn($q2) =>
                        $q2->where('id', $libroId)
                    )
                )
                ->when($usuario, fn($q) =>
                    $q->whereHas('user', fn($q2) =>
                        $q2->where('name', 'like', "%{$usuario}%")
                    )
                )
                ->when($usuarioId, fn($q) =>
                    $q->whereHas('user', fn($q2) =>
                        $q2->where('id', $usuarioId)
                    )
                )
                ->when($fechaPrestamoInicio, fn($q) =>
                    $q->where('fecha_prestamo', '>=', $fechaPrestamoInicio)
                )
                ->when($fechaPrestamoFin, fn($q) =>
                    $q->where('fecha_prestamo', '<=', $fechaPrestamoFin)
                )
                ->when($fechaDevolutionInicio, fn($q) =>
                    $q->where('fecha_devolucion', '>=', $fechaDevolutionInicio)
                )
                ->when($fechaDevolutionFin, fn($q) =>
                    $q->where('fecha_devolucion', '<=', $fechaDevolutionFin)
                );
        };

        $prestamosActivos = Prestamo::whereNull('fecha_devolucion')
            ->where('fecha_devolucion_esperada', '>=', now())
            ->whereHas('ejemplar')
            ->tap($aplicarFiltros)
            ->paginate(15, ['*'], 'page_activos');

        $prestamosExpirados = Prestamo::whereNull('fecha_devolucion')
            ->where('fecha_devolucion_esperada', '<', now())
            ->whereHas('ejemplar')
            ->tap($aplicarFiltros)
            ->paginate(15, ['*'], 'page_expirados');

        $prestamosPasados = Prestamo::whereNotNull('fecha_devolucion')
            ->whereHas('ejemplar')
            ->tap($aplicarFiltros)
            ->paginate(15, ['*'], 'page_pasados');

        return view('admin.reportes', compact(
                'prestamosActivos',
                'prestamosExpirados',
                'prestamosPasados'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
