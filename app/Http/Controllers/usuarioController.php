<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;

class usuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('roles');

        // Búsqueda por nombre o email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filtro por rol
        if ($request->filled('rol')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->rol);
            });
        }

        // Ordenar por nombre
        if ($request->orden == 'nombre_asc') {
            $query->orderBy('name', 'asc');
        } elseif ($request->orden == 'nombre_desc') {
            $query->orderBy('name', 'desc');
        }

        $usuarios = $query->paginate(10)->withQueryString();
        return view('admin.usuarios', compact('usuarios'));
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|same:password',
            'rol' => 'required|in:lector,admin',
        ]);


        user::create([
            'name' => $request->nombre,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ])->assignRole($request->rol);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario agregado exitosamente.');
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
        $usuario = user::find($id);
        return view('admin.usuario_editar', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $usuario = User::findOrFail($id);

        if ($request->filled('rol') && !$request->filled('nombre')) {
            $request->validate([
                'rol' => 'required|in:lector,admin',
            ]);
            $usuario->syncRoles([$request->rol]);

            return redirect()->route('admin.usuarios.index')->with('success', 'Rol actualizado exitosamente.');
        }

        $request->validate([
            'nombre'   => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'rol'      => 'required|in:lector,admin',
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        $usuario->update([
            'name'  => $request->nombre,
            'email' => $request->email,
        ]);
        $usuario->syncRoles([$request->rol]);
        if ($request->filled('password')) {
            $usuario->update([
                'password' => bcrypt($request->password),
            ]);
        }

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $usuario = user::findOrFail($id);
        $usuario->delete();

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
