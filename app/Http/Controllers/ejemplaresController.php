<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Libro;
use App\Models\Ejemplar;

class ejemplaresController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ejemplares = Ejemplar::with('libro')
            ->when(request('search'), function ($q, $search) {
                $q->where('id', $search)
                ->orWhereHas('libro', fn($q) => $q->where('titulo', 'like', "%{$search}%"));
            })
            ->paginate(20);
        $libros = Libro::all();
        return view('admin.ejemplares', compact('ejemplares', 'libros'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'libro_id' => 'required|exists:libros,id',
            'estado' => 'required|in:disponible,prestado,dañado',
            'ubicacion' => 'required',
        ]);

        Ejemplar::create($request->all());

        return redirect()->route('admin.ejemplares.index')->with('success', 'Ejemplar creado exitosamente.');
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
        $ejemplar = Ejemplar::findOrFail($id);
        return view('admin.ejemplar_editar', compact('ejemplar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'estado' => 'sometimes|in:disponible,prestado,dañado',
            'ubicacion' => 'required',
        ]);

        $ejemplar = Ejemplar::findOrFail($id);
        $ejemplar->update($request->all());

        return redirect()->route('admin.ejemplares.index')->with('success', 'Ejemplar actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $ejemplar = Ejemplar::findOrFail($id);
        $ejemplar->delete();

        return redirect()->route('admin.ejemplares.index')->with('success', 'Ejemplar eliminado exitosamente.');
    }
}
