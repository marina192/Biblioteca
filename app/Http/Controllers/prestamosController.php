<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Prestamo;
use App\Models\Ejemplar;

class prestamosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (auth()->user()->hasRole('admin')) {
            $libro     = $request->input('libro');
            $libroId   = $request->input('libro_id');
            $usuario   = $request->input('usuario');
            $usuarioId = $request->input('usuario_id');

            $aplicarFiltros = function ($query) use ($libro, $libroId, $usuario, $usuarioId) {
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

            return view('admin.prestamos', compact(
                'prestamosActivos',
                'prestamosExpirados',
                'prestamosPasados'
            ));
        }
        if(auth()->user()->hasRole('lector')) {
            $libro     = $request->input('libro');
            $libroId   = $request->input('libro_id');

            $aplicarFiltros = function ($query) use ($libro, $libroId) {
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
                    );
            };

            $prestamosActivos = Prestamo::where('user_id', auth()->id())
                ->where('fecha_devolucion', null)
                ->where('fecha_devolucion_esperada', '>=', now())
                ->whereHas('ejemplar')
                ->tap($aplicarFiltros)
                ->paginate(15, ['*'], 'page_activos');
            $prestamosExpirados = Prestamo::where('user_id', auth()->id())
                ->whereNull('fecha_devolucion')
                ->where('fecha_devolucion_esperada', '<', now())
                ->whereHas('ejemplar')
                ->tap($aplicarFiltros)
                ->paginate(15, ['*'], 'page_expirados');
            $prestamosPasados = Prestamo::where('user_id', auth()->id())
                ->whereNotNull('fecha_devolucion')
                ->whereHas('ejemplar')
                ->tap($aplicarFiltros)
                ->paginate(15, ['*'], 'page_pasados');
            return view('lector.prestamos', compact('prestamosPasados', 'prestamosExpirados', 'prestamosActivos'));
        }

        return redirect()->route('home')->with('error', 'Acceso no autorizado');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $ejemplar = Ejemplar::where('libro_id', $request->libro_id)->where('estado', 'disponible')->first();
        Prestamo::create([
            'user_id' => auth()->id(),
            'ejemplar_id' => $ejemplar->id,
            'fecha_prestamo' => now(),
            'fecha_devolucion_esperada' => now()->addDays(15),
        ]);
        $ejemplar->update(['estado' => 'prestado']);
        return redirect()->back()->with('success', 'Libro prestado exitosamente');
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
        $prestamo = Prestamo::findOrFail($id);

        if ($request->accion === 'eliminar') {
            $prestamo->user->update(['prestamos_blocked' => true]);
            $prestamo->ejemplar->delete();
            $prestamo->delete();
            return redirect()->back()->with('success', 'Préstamo eliminado exitosamente');
        } elseif ($request->accion === 'devolver') {
            $prestamo->update(['fecha_devolucion' => now()]);
            $prestamo->ejemplar->update(['estado' => 'disponible']);
            return redirect()->back()->with('success', 'Libro devuelto exitosamente');
        }

        return redirect()->back()
            ->with('error', 'Acción inválida');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
