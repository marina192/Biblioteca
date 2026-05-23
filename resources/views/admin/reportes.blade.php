{{-- Vista: resources/views/admin/reportes/index.blade.php --}}
<x-layouts::app_administrador>

<div class="repo-page">

    {{-- Encabezado --}}
    <div class="repo-header">
        <h1 class="repo-title">Reportes</h1>
        <p class="repo-subtitle">Genera y descarga reportes de la biblioteca con filtros personalizados.</p>
    </div>

    {{-- Grid superior: filtros + acción --}}
    <div class="repo-top-grid">

        {{-- Panel de filtros --}}
        <div class="repo-panel">
            <p class="repo-panel-heading">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 3H2l8 9.46V19l4 2v-8.54L22 3z"/></svg>
                Parámetros del reporte
            </p>

            <form method="GET" action="{{ route('admin.reportes.index') }}">

                <div class="repo-fields-grid">
                    <div class="repo-field">
                        <label for="r-libro">Libro</label>
                        <input type="text" id="r-libro" name="libro"
                            placeholder="Título del libro…" value="{{ request('libro') }}">
                    </div>
                    <div class="repo-field">
                        <label for="r-libro-id">ID libro</label>
                        <input type="number" id="r-libro-id" name="libro_id"
                            placeholder="Ej: 12" min="1" value="{{ request('libro_id') }}">
                    </div>
                    <div class="repo-field">
                        <label for="r-usuario">Usuario</label>
                        <input type="text" id="r-usuario" name="usuario"
                            placeholder="Nombre del usuario…" value="{{ request('usuario') }}">
                    </div>
                    <div class="repo-field">
                        <label for="r-usuario-id">ID usuario</label>
                        <input type="number" id="r-usuario-id" name="usuario_id"
                            placeholder="Ej: 5" min="1" value="{{ request('usuario_id') }}">
                    </div>
                </div>

                <div class="repo-divider"></div>
                <p class="repo-section-label">Fecha de préstamo</p>
                <div class="repo-dates-grid">
                    <div class="repo-field">
                        <label for="r-fp-ini">Desde</label>
                        <input type="date" id="r-fp-ini" name="fecha_prestamo_inicio"
                            value="{{ request('fecha_prestamo_inicio') }}">
                    </div>
                    <div class="repo-field">
                        <label for="r-fp-fin">Hasta</label>
                        <input type="date" id="r-fp-fin" name="fecha_prestamo_fin"
                            value="{{ request('fecha_prestamo_fin') }}">
                    </div>
                </div>

                <p class="repo-section-label">Fecha de devolución</p>
                <div class="repo-dates-grid">
                    <div class="repo-field">
                        <label for="r-fd-ini">Desde</label>
                        <input type="date" id="r-fd-ini" name="fecha_devolucion_inicio"
                            value="{{ request('fecha_devolucion_inicio') }}">
                    </div>
                    <div class="repo-field">
                        <label for="r-fd-fin">Hasta</label>
                        <input type="date" id="r-fd-fin" name="fecha_devolucion_fin"
                            value="{{ request('fecha_devolucion_fin') }}">
                    </div>
                </div>

                {{-- Pills de filtros activos --}}
                @php
                    $hayFiltros = request()->hasAny([
                        'libro','libro_id','usuario','usuario_id',
                        'fecha_prestamo_inicio','fecha_prestamo_fin',
                        'fecha_devolucion_inicio','fecha_devolucion_fin'
                    ]);
                @endphp
                @if($hayFiltros)
                <div class="repo-pills">
                    @if(request('libro'))
                        <span class="repo-pill">📖 {{ request('libro') }}</span>
                    @endif
                    @if(request('libro_id'))
                        <span class="repo-pill">ID libro #{{ request('libro_id') }}</span>
                    @endif
                    @if(request('usuario'))
                        <span class="repo-pill">👤 {{ request('usuario') }}</span>
                    @endif
                    @if(request('usuario_id'))
                        <span class="repo-pill">ID usuario #{{ request('usuario_id') }}</span>
                    @endif
                    @if(request('fecha_prestamo_inicio') || request('fecha_prestamo_fin'))
                        <span class="repo-pill">
                            Préstamo:
                            {{ request('fecha_prestamo_inicio') ? 'desde '.request('fecha_prestamo_inicio') : '' }}
                            {{ request('fecha_prestamo_fin') ? 'hasta '.request('fecha_prestamo_fin') : '' }}
                        </span>
                    @endif
                    @if(request('fecha_devolucion_inicio') || request('fecha_devolucion_fin'))
                        <span class="repo-pill">
                            Devolución:
                            {{ request('fecha_devolucion_inicio') ? 'desde '.request('fecha_devolucion_inicio') : '' }}
                            {{ request('fecha_devolucion_fin') ? 'hasta '.request('fecha_devolucion_fin') : '' }}
                        </span>
                    @endif
                </div>
                @endif

                <div class="repo-filter-actions">
                    <button type="submit" class="repo-btn-search">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        Buscar
                    </button>
                    @if($hayFiltros)
                        <a href="{{ route('admin.reportes.index') }}" class="repo-btn-clear">
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6 6 18M6 6l12 12"/></svg>
                            Limpiar
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Panel de acción --}}
        <div class="repo-panel repo-action-panel">
            <div class="repo-action-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/>
                    <line x1="9" y1="15" x2="15" y2="15"/>
                </svg>
            </div>
            <p class="repo-action-title">¿Listo para generar?</p>
            <p class="repo-action-desc">
                Los filtros actuales capturan
                <span class="repo-counter">
                    {{ isset($total) ? $total : ($prestamosActivos->count() + $prestamosExpirados->count() + $prestamosPasados->count()) }}
                </span>
                préstamos.
            </p>

            <a href="{{ route('admin.pdf.descargar', array_merge(['tipo' => 'prestamos'], request()->query())) }}"
                class="repo-btn-generate">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Generar y descargar PDF
            </a>

            <a href="{{ route('admin.pdf.ver', array_merge(['tipo' => 'prestamos'], request()->query())) }}"
                class="repo-btn-view">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                Ver PDF en el navegador
            </a>
        </div>
    </div>

    {{-- Tabla de preview --}}
    <div class="repo-panel">
        <div class="repo-preview-header">
            <p class="repo-preview-title">
                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M3 15h18M9 3v18"/></svg>
                Vista previa
            </p>
            <div class="repo-stats">
                <span class="repo-stat"><span class="repo-dot repo-dot-active"></span> Activos: {{ $prestamosActivos->count() }}</span>
                <span class="repo-stat"><span class="repo-dot repo-dot-overdue"></span> Vencidos: {{ $prestamosExpirados->count() }}</span>
                <span class="repo-stat"><span class="repo-dot repo-dot-returned"></span> Devueltos: {{ $prestamosPasados->count() }}</span>
            </div>
        </div>

        <table class="repo-table">
            <thead>
                <tr>
                    <th>Libro</th>
                    <th>Usuario</th>
                    <th>Fecha préstamo</th>
                    <th>Devolución esperada</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prestamosActivos->take(3)->merge($prestamosExpirados->take(2))->merge($prestamosPasados->take(2)) as $p)
                    @php
                        if ($p->fecha_devolucion) {
                            $estado = 'returned'; $estadoLabel = 'Devuelto';
                        } elseif ($p->fecha_devolucion_esperada < now()) {
                            $estado = 'overdue'; $estadoLabel = 'Vencido';
                        } else {
                            $estado = 'active'; $estadoLabel = 'Activo';
                        }
                    @endphp
                    <tr>
                        <td>
                            <p class="repo-book-title">{{ $p->ejemplar->libro->titulo }}</p>
                        </td>
                        <td style="color:#6b7280">{{ $p->user->name ?? 'Usuario #'.$p->user_id }}</td>
                        <td style="color:#6b7280">{{ $p->fecha_prestamo->format('d/m/Y') }}</td>
                        <td class="{{ $estado === 'overdue' ? 'repo-date-overdue' : '' }}">
                            {{ $p->fecha_devolucion_esperada->format('d/m/Y') }}
                        </td>
                        <td><span class="repo-badge repo-badge-{{ $estado }}">● {{ $estadoLabel }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center;color:#6b7280;padding:2rem">
                            Sin resultados para los filtros aplicados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @php
            $totalPreview = $prestamosActivos->count() + $prestamosExpirados->count() + $prestamosPasados->count();
        @endphp
        @if($totalPreview > 7)
        <div class="repo-show-more">
            <a href="{{ route('admin.pdf.ver', array_merge(['tipo' => 'prestamos'], request()->query())) }}">
                Ver todos los {{ $totalPreview }} préstamos ↓
            </a>
        </div>
        @endif
    </div>

</div>

</x-layouts::app_administrador>