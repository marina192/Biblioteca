<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Libro;
use App\Models\Ejemplar;
use App\Models\Prestamo;
use Carbon\Carbon;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Credenciales inválidas'], 401);
        }
        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json(['token' => $token], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Sesión cerrada'], 200);
    }

    // GET /api/libros
    // Obtiene la lista completa de libros registrados en el sistema.
    public function indexLibros()
    {
        return response()->json(Libro::with('categorias')->get(), 200);
    }

    // GET /api/libros/{id}
    // Devuelve la información detallada de un libro específico identificado por su ID.
    public function showLibro($id)
    {
        $libro = Libro::with('categorias')->find($id);
        if (!$libro) {
            return response()->json(['error' => 'El libro que buscas no existe'], 404);
        }
        return response()->json($libro, 200);
    }

    // POST /api/prestamos
    // Registra un nuevo préstamo de un ejemplar disponible asociado a un libro.
    public function storePrestamo(Request $request)
    {
        $libro = Libro::find($request->libro_id);
        if (!$libro) {
            return response()->json(['error' => 'Libro no encontrado'], 404);
        }

        $user = $request->user();
        if ($user->prestamos_blocked) {
            return response()->json(['error' => 'No puedes solicitar préstamos debido a bloqueos anteriores por no devolver los libros a tiempo. Por favor, contacta con el personal de la biblioteca para más información.'], 403);
        }

        $disponibles = Ejemplar::where('libro_id', $request->libro_id)
            ->where('estado', 'disponible')
            ->count();
        if ($disponibles < 1) {
            return response()->json(['error' => 'No hay ejemplares disponibles'], 422);
        }

        $ejemplar = Ejemplar::where('estado', 'disponible')->first();
        
        $prestamo = Prestamo::create([
            'ejemplar_id'               => $ejemplar->id,
            'user_id'                   => $user->id,
            'fecha_prestamo'            => Carbon::today(),
            'fecha_devolucion_esperada' => Carbon::today()->addDays(15),
        ]);

        $ejemplar->update(['estado' => 'prestado']);

        return response()->json($prestamo, 201);
    }
}