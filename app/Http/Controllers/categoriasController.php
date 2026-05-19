<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Categoria;

class categoriasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Categoria::query();

        // Buscar
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        $categorias = $query->paginate(10)->withQueryString();

        return view('admin.categorias', compact('categorias'));
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
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'imagenes.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $rutas = [];

        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $ruta = $imagen->store('categorias', 'public');
                $rutas[] = $ruta;
            }
        }

        Categoria::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'imagenes' => $rutas,
        ]);

        return redirect()->route('categorias.index')->with('success', 'Categoría creada exitosamente.');
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
        $categoria = Categoria::find($id);
        return view('admin.categoria_editar', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'imagenes.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagenesAnteriores = $categoria->imagenes ?? [];
        $imagenesExistentes = $request->imagenes_existentes ?? [];

        $nuevasImagenes = $request->hasFile('imagenes')
        ? count($request->file('imagenes'))
        : 0;

        if ((count($imagenesExistentes) + $nuevasImagenes) < 1) {
            return back()
                ->withErrors([
                    'imagenes' => 'La categoría debe tener al menos una imagen.'
                ])
                ->withInput();
        }

        $imagenesEliminadas = array_diff($imagenesAnteriores, $imagenesExistentes);

        foreach ($imagenesEliminadas as $imagen) {
            Storage::disk('public')->delete($imagen);
        }

        $rutas = $imagenesExistentes;
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $ruta = $imagen->store('categorias', 'public');
                $rutas[] = $ruta;
            }
        }

        $categoria->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'imagenes' => $rutas,
        ]);

        return redirect()->route('categorias.index')->with('success', 'Categoría actualizada.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoria = Categoria::findOrFail($id);
        if ($categoria->imagenes) {
            foreach ($categoria->imagenes as $ruta) {
                Storage::disk('public')->delete($ruta);
            }
        }
        $categoria->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoría eliminada.');
    }
}
