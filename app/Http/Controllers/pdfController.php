<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Prestamo;

class pdfController extends Controller
{
    // Descarga directa al navegador
    public function descargar(Request $request)
    {
        $tipo = $request->input('tipo');
        $titulo = match($tipo) {
            'prestamos' => 'Reporte de préstamos',
            'libros'    => 'Reporte de libros',
            'usuarios'  => 'Reporte de usuarios',
            default     => 'Reporte',
        };

        if ($tipo === 'prestamos') {
            $query = Prestamo::with('ejemplar.libro', 'user')
                ->when($request->libro, fn($q) =>
                    $q->whereHas('ejemplar.libro', fn($q2) =>
                        $q2->where('titulo', 'like', '%' . $request->libro . '%')
                    )
                )
                ->when($request->libro_id, fn($q) =>
                    $q->whereHas('ejemplar', fn($q2) =>
                        $q2->where('libro_id', $request->libro_id)
                    )
                )
                ->when($request->usuario, fn($q) =>
                    $q->whereHas('user', fn($q2) =>
                        $q2->where('name', 'like', '%' . $request->usuario . '%')
                    )
                )
                ->when($request->usuario_id, fn($q) =>
                    $q->where('user_id', $request->usuario_id)
                )
                ->when($request->fecha_prestamo_inicio, fn($q) =>
                    $q->whereDate('fecha_prestamo', '>=', $request->fecha_prestamo_inicio)
                )
                ->when($request->fecha_prestamo_fin, fn($q) =>
                    $q->whereDate('fecha_prestamo', '<=', $request->fecha_prestamo_fin)
                )
                ->when($request->fecha_devolucion_inicio, fn($q) =>
                    $q->whereDate('fecha_devolucion', '>=', $request->fecha_devolucion_inicio)
                )
                ->when($request->fecha_devolucion_fin, fn($q) =>
                    $q->whereDate('fecha_devolucion', '<=', $request->fecha_devolucion_fin)
                );

            $prestamosActivos = (clone $query)
                ->whereNull('fecha_devolucion')
                ->where('fecha_devolucion_esperada', '>=', now())
                ->get();

            $prestamosExpirados = (clone $query)
                ->whereNull('fecha_devolucion')
                ->where('fecha_devolucion_esperada', '<', now())
                ->get();

            $prestamosPasados = (clone $query)
                ->whereNotNull('fecha_devolucion')
                ->get();

            $pdf = Pdf::loadView('pdf.reportePrestamos', compact(
            'titulo',
            'prestamosActivos',
            'prestamosExpirados',
            'prestamosPasados'));
            return $pdf->download('reporte-préstamos.pdf');
        }
    }

    // ­ Muestra el PDF en el navegador (inline)
    public function ver(Request $request)
    {
        $tipo = $request->input('tipo');
        $titulo = match($tipo) {
            'prestamos' => 'Reporte de préstamos',
            'libros'    => 'Reporte de libros',
            'usuarios'  => 'Reporte de usuarios',
            default     => 'Reporte',
        };

        if ($tipo === 'prestamos') {
            $query = Prestamo::with('ejemplar.libro', 'user')
                ->when($request->libro, fn($q) =>
                    $q->whereHas('ejemplar.libro', fn($q2) =>
                        $q2->where('titulo', 'like', '%' . $request->libro . '%')
                    )
                )
                ->when($request->libro_id, fn($q) =>
                    $q->whereHas('ejemplar', fn($q2) =>
                        $q2->where('libro_id', $request->libro_id)
                    )
                )
                ->when($request->usuario, fn($q) =>
                    $q->whereHas('user', fn($q2) =>
                        $q2->where('name', 'like', '%' . $request->usuario . '%')
                    )
                )
                ->when($request->usuario_id, fn($q) =>
                    $q->where('user_id', $request->usuario_id)
                )
                ->when($request->fecha_prestamo_inicio, fn($q) =>
                    $q->whereDate('fecha_prestamo', '>=', $request->fecha_prestamo_inicio)
                )
                ->when($request->fecha_prestamo_fin, fn($q) =>
                    $q->whereDate('fecha_prestamo', '<=', $request->fecha_prestamo_fin)
                )
                ->when($request->fecha_devolucion_inicio, fn($q) =>
                    $q->whereDate('fecha_devolucion', '>=', $request->fecha_devolucion_inicio)
                )
                ->when($request->fecha_devolucion_fin, fn($q) =>
                    $q->whereDate('fecha_devolucion', '<=', $request->fecha_devolucion_fin)
                );

            $prestamosActivos = (clone $query)
                ->whereNull('fecha_devolucion')
                ->where('fecha_devolucion_esperada', '>=', now())
                ->get();

            $prestamosExpirados = (clone $query)
                ->whereNull('fecha_devolucion')
                ->where('fecha_devolucion_esperada', '<', now())
                ->get();

            $prestamosPasados = (clone $query)
                ->whereNotNull('fecha_devolucion')
                ->get();
        }

        return Pdf::loadView('pdf.reportePrestamos', compact(
            'titulo',
            'prestamosActivos',
            'prestamosExpirados',
            'prestamosPasados'
        ))->stream('reportePrestamos.pdf');
    }

    // Guarda el PDF en storage/
    public function guardar()
    {
        $datos = ['titulo' => 'Reporte guardado', 'alumnos' => []];
        $pdf = Pdf::loadView('pdf.reporte', $datos);
        $ruta = 'pdfs/reporte-' . now()->format('Ymd-His') . '.pdf';
        \Storage::put($ruta, $pdf->output());
        return response()->json(['ruta' => $ruta]);
    }
}