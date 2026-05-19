<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Categoria;
use App\Models\CategoriaLibro;
use App\Models\Libro;

class librosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Libro::with(['categorias']);

        // Buscar
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                ->orWhere('autor', 'like', "%{$search}%")
                ->orWhere('editorial', 'like', "%{$search}%");
            });
        }

        // Filtrar categoría
        if ($request->filled('categoria')) {
            $query->whereHas('categorias', function ($q) use ($request) {
                $q->where('categorias.id', $request->categoria);
            });
        }

        $libros = $query->paginate(10)->withQueryString();
        $categorias = Categoria::all();

        return view('admin.libros', compact('libros','categorias'));
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
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string',
            'editorial' => 'required|string',
            'fecha_publicacion' => 'required|date',
            'imagenes.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'categorias' => 'nullable|array',
            'categorias.*' => 'exists:categorias,id',
        ]);

        $rutas = [];

        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $ruta = $imagen->store('libros', 'public');
                $rutas[] = $ruta;
            }
        }

        $libro = Libro::create([
            'titulo' => $request->titulo,
            'autor' => $request->autor,
            'editorial' => $request->editorial,
            'fecha_publicacion' => $request->fecha_publicacion,
            'imagenes' => $rutas,
        ]);

        if ($request->filled('categorias')) {
            $libro->categorias()->attach($request->categorias);
        }

        return redirect()->route('admin.libros.index')->with('success', 'Libro creado exitosamente.');
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
        $libro = Libro::with('categorias')->find($id);
        $categorias = Categoria::all();
        return view('admin.libro_editar', compact('libro', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'editorial' => 'required|string|max:255',
            'fecha_publicacion' => 'required|date',
            'imagenes.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagenesAnteriores = $libro->imagenes ?? [];
        $imagenesExistentes = $request->imagenes_existentes ?? [];
        $imagenesEliminadas = array_diff($imagenesAnteriores, $imagenesExistentes);

        foreach ($imagenesEliminadas as $imagen) {
            Storage::disk('public')->delete($imagen);
        }

        $rutas = $imagenesExistentes;
        if ($request->hasFile('imagenes')) {
            foreach ($request->file('imagenes') as $imagen) {
                $ruta = $imagen->store('libros', 'public');
                $rutas[] = $ruta;
            }
        }

        $libro = Libro::findOrFail($id);

        $libro->update([
            'titulo' => $request->titulo,
            'autor' => $request->autor,
            'editorial' => $request->editorial,
            'fecha_publicacion' => $request->fecha_publicacion,
            'imagenes' => $rutas,
        ]);

        return redirect()->route('admin.libros.index')->with('success', 'Libro actualizado.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $libro = Libro::findOrFail($id);

        // Eliminar imágenes del almacenamiento
        if ($libro->imagenes) {
            foreach ($libro->imagenes as $imagen) {
                Storage::disk('public')->delete($imagen);
            }
        }

        $libro->delete();

        return redirect()->route('admin.libros.index')->with('success', 'Libro eliminado exitosamente.');
    }
}
