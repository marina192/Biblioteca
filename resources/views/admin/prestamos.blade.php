<x-layouts::app_administrador>

<div class="pres-page">

    {{-- ===== HEADER ===== --}}
    <div class="pres-header">
        <div class="pres-header-left">
            <h1>Préstamos Activos</h1>
            <p>Seguimiento de ejemplares prestados. Asegúrate de que todos los libros sean devueltos en la fecha indicada.</p>
        </div>
    </div>

    {{-- ===== STATS ===== --}}
    <div class="pres-stats">
        <div class="pres-stat-card">
            <div class="pres-stat-label">Total préstamos</div>
            <div class="pres-stat-value">{{ $prestamosActivos->total() + $prestamosExpirados->total() + $prestamosPasados->total() }}</div>
        </div>
        <div class="pres-stat-card">
            <div class="pres-stat-label">Activos</div>
            <div class="pres-stat-value pres-stat-value--cyan">{{ $prestamosActivos->total() }}</div>
        </div>
        <div class="pres-stat-card pres-stat-card--warning">
            <div class="pres-stat-label">Vencidos (mora)</div>
            <div class="pres-stat-value pres-stat-value--red">{{ $prestamosExpirados->total() }}</div>
        </div>
        <div class="pres-stat-card pres-stat-card--returning">
            <div class="pres-stat-label">Devueltos</div>
            <div class="pres-stat-value pres-stat-value--purple">{{ $prestamosPasados->total() }}</div>
        </div>
    </div>

    {{-- ===== BUSCADORES ===== --}}
    <form method="GET" action="{{ route('admin.prestamos.index') }}" class="pres-search-bar">

        {{-- Búsqueda por libro --}}
        <div class="pres-search-group">
            <label class="pres-search-label" for="pres-libro">Libro</label>
            <div class="pres-search-input-wrap">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                </svg>
                <input
                    type="text"
                    id="pres-libro"
                    name="libro"
                    class="pres-search-input"
                    placeholder="Título del libro..."
                    value="{{ request('libro') }}"
                >
            </div>
        </div>

        <div class="pres-search-group" style="max-width:130px">
            <label class="pres-search-label" for="pres-libro-id">ID libro</label>
            <div class="pres-search-input-wrap">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="3"/>
                    <path d="M9 9h1v6H9M14 9h2a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1h-1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1h-2"/>
                </svg>
                <input
                    type="number"
                    id="pres-libro-id"
                    name="libro_id"
                    class="pres-search-input"
                    placeholder="Ej: 12"
                    value="{{ request('libro_id') }}"
                    min="1"
                >
            </div>
        </div>

        <div class="pres-search-divider"></div>

        {{-- Búsqueda por usuario --}}
        <div class="pres-search-group">
            <label class="pres-search-label" for="pres-usuario">Usuario</label>
            <div class="pres-search-input-wrap">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                </svg>
                <input
                    type="text"
                    id="pres-usuario"
                    name="usuario"
                    class="pres-search-input"
                    placeholder="Nombre del usuario..."
                    value="{{ request('usuario') }}"
                >
            </div>
        </div>

        <div class="pres-search-group" style="max-width:130px">
            <label class="pres-search-label" for="pres-usuario-id">ID usuario</label>
            <div class="pres-search-input-wrap">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="18" height="18" rx="3"/>
                    <path d="M9 9h1v6H9M14 9h2a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1h-1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1h-2"/>
                </svg>
                <input
                    type="number"
                    id="pres-usuario-id"
                    name="usuario_id"
                    class="pres-search-input"
                    placeholder="Ej: 5"
                    value="{{ request('usuario_id') }}"
                    min="1"
                >
            </div>
        </div>

        <div class="pres-search-actions">
            <button type="submit" class="pres-btn-search">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                Buscar
            </button>
            @if(request()->hasAny(['libro','libro_id','usuario','usuario_id']))
                <a href="{{ route('admin.prestamos.index') }}" class="pres-btn-clear">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M18 6 6 18M6 6l12 12"/></svg>
                    Limpiar
                </a>
            @endif
        </div>
    </form>

    {{-- ===== PILLS DE FILTROS ACTIVOS ===== --}}
    @if(request()->hasAny(['libro','libro_id','usuario','usuario_id']))
    <div class="pres-active-filters">
        @if(request('libro'))
            <div class="pres-filter-pill">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                Libro: <span>{{ request('libro') }}</span>
            </div>
        @endif
        @if(request('libro_id'))
            <div class="pres-filter-pill">
                ID libro: <span>#{{ request('libro_id') }}</span>
            </div>
        @endif
        @if(request('usuario'))
            <div class="pres-filter-pill">
                <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                Usuario: <span>{{ request('usuario') }}</span>
            </div>
        @endif
        @if(request('usuario_id'))
            <div class="pres-filter-pill">
                ID usuario: <span>#{{ request('usuario_id') }}</span>
            </div>
        @endif
    </div>
    @endif

    {{-- ===== MACRO para tabla reutilizable ===== --}}
    @php
        $avatarPalettes = [
            'activos'   => ['pres-avatar--cyan','pres-avatar--teal','pres-avatar--purple','pres-avatar--amber','pres-avatar--slate'],
            'expirados' => ['pres-avatar--red','pres-avatar--amber','pres-avatar--slate'],
            'pasados'   => ['pres-avatar--slate','pres-avatar--teal','pres-avatar--purple'],
        ];
    @endphp

    {{-- ===== TABLA: ACTIVOS ===== --}}
    <div class="pres-section-title">Préstamos activos</div>

    <div class="pres-table-wrapper">
        @forelse($prestamosActivos as $prestamo)
            @if($loop->first)
            <table class="pres-table">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Libro</th>
                        <th>Fecha préstamo</th>
                        <th>Fecha devolución</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
            @endif

            @php
                $initials    = strtoupper(implode('', array_map(fn($w) => $w[0], array_slice(explode(' ', $prestamo->user->name ?? 'Usuario eliminado'), 0, 2))));
                $avatarClass = $avatarPalettes['activos'][$loop->index % count($avatarPalettes['activos'])];
            @endphp

            <tr>
                <td>
                    <div class="pres-borrower">
                        <div class="pres-avatar {{ $avatarClass }}">{{ $initials }}</div>
                        <div class="pres-borrower-info">
                            <strong>{{ $prestamo->user->name ?? 'Usuario eliminado' }}</strong>
                            <span>#{{ $prestamo->user->id ?? '—' }}</span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="pres-book">
                        <strong>{{ $prestamo->ejemplar->libro->titulo }}</strong>
                        <span>Ejemplar #{{ $prestamo->ejemplar->id }}</span>
                    </div>
                </td>
                <td>{{ $prestamo->fecha_prestamo->format('d M, Y') }}</td>
                <td>{{ $prestamo->fecha_devolucion_esperada->format('d M, Y') }}</td>
                <td><span class="pres-badge pres-badge--active">Activo</span></td>
                <td>
                    <div class="pres-actions">
                        <form action="{{ route('admin.prestamos.update', $prestamo->id) }}" method="POST" style="display:contents">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="pres-btn-icon" title="Devolver">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>

            @if($loop->last)
                </tbody>
            </table>
            <div class="pres-table-footer">
                <span>Mostrando {{ $prestamosActivos->count() }} de {{ $prestamosActivos->total() }} préstamos activos</span>
                {{ $prestamosActivos->appends(request()->query())->links() }}
            </div>
            @endif

        @empty
            <div class="pres-empty">No hay préstamos activos con los filtros aplicados.</div>
        @endforelse
    </div>

    {{-- ===== TABLA: VENCIDOS ===== --}}
    <div class="pres-section-title">Préstamos vencidos</div>

    <div class="pres-table-wrapper">
        @forelse($prestamosExpirados as $prestamo)
            @if($loop->first)
            <table class="pres-table">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Libro</th>
                        <th>Fecha préstamo</th>
                        <th>Fecha devolución</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
            @endif

            @php
                $initials    = strtoupper(implode('', array_map(fn($w) => $w[0], array_slice(explode(' ', $prestamo->user->name ?? 'Usuario eliminado'), 0, 2))));
                $avatarClass = $avatarPalettes['expirados'][$loop->index % count($avatarPalettes['expirados'])];
            @endphp

            <tr>
                <td>
                    <div class="pres-borrower">
                        <div class="pres-avatar {{ $avatarClass }}">{{ $initials }}</div>
                        <div class="pres-borrower-info">
                            <strong>{{ $prestamo->user->name ?? 'Usuario eliminado' }}</strong>
                            <span>#{{ $prestamo->user->id ?? '—' }}</span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="pres-book">
                        <strong>{{ $prestamo->ejemplar->libro->titulo }}</strong>
                        <span>Ejemplar #{{ $prestamo->ejemplar->id }}</span>
                    </div>
                </td>
                <td>{{ $prestamo->fecha_prestamo->format('d M, Y') }}</td>
                <td class="pres-date-overdue">{{ $prestamo->fecha_devolucion_esperada->format('d M, Y') }}</td>
                <td><span class="pres-badge pres-badge--overdue">Vencido</span></td>
                <td>
                    <div class="pres-actions">
                        <form action="{{ route('admin.prestamos.update', $prestamo->id) }}" method="POST" style="display:contents">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="accion" value="devolver">
                            <button type="submit" class="pres-btn-icon" title="Devolver">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/></svg>
                            </button>
                        </form>
                        <form action="{{ route('admin.prestamos.update', $prestamo->id) }}" method="POST" style="display:contents">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="accion" value="eliminar">
                            <button type="submit" class="pres-btn-icon pres-btn-icon--danger" title="Eliminar">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6l-1 14H6L5 6M10 6V4h4v2"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>

            @if($loop->last)
                </tbody>
            </table>
            <div class="pres-table-footer">
                <span>Mostrando {{ $prestamosExpirados->count() }} de {{ $prestamosExpirados->total() }} préstamos vencidos</span>
                {{ $prestamosExpirados->appends(request()->query())->links() }}
            </div>
            @endif

        @empty
            <div class="pres-empty">No hay préstamos vencidos con los filtros aplicados.</div>
        @endforelse
    </div>

    {{-- ===== TABLA: HISTORIAL ===== --}}
    <div class="pres-section-title">Historial de préstamos</div>

    <div class="pres-table-wrapper">
        @forelse($prestamosPasados as $prestamo)
            @if($loop->first)
            <table class="pres-table">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Libro</th>
                        <th>Fecha préstamo</th>
                        <th>Fecha esperada</th>
                        <th>Fecha devolución</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
            @endif

            @php
                $initials    = strtoupper(implode('', array_map(fn($w) => $w[0], array_slice(explode(' ', $prestamo->user->name ?? 'Usuario eliminado'), 0, 2))));
                $avatarClass = $avatarPalettes['pasados'][$loop->index % count($avatarPalettes['pasados'])];
            @endphp

            <tr>
                <td>
                    <div class="pres-borrower">
                        <div class="pres-avatar {{ $avatarClass }}">{{ $initials }}</div>
                        <div class="pres-borrower-info">
                            <strong>{{ $prestamo->user->name ?? 'Usuario eliminado' }}</strong>
                            <span>#{{ $prestamo->user->id ?? '—' }}</span>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="pres-book">
                        <strong>{{ $prestamo->ejemplar->libro->titulo }}</strong>
                        <span>Ejemplar #{{ $prestamo->ejemplar->id }}</span>
                    </div>
                </td>
                <td>{{ $prestamo->fecha_prestamo->format('d M, Y') }}</td>
                <td>{{ $prestamo->fecha_devolucion_esperada->format('d M, Y') }}</td>
                <td>{{ $prestamo->fecha_devolucion->format('d M, Y') }}</td>
                <td><span class="pres-badge pres-badge--returned">Devuelto</span></td>
            </tr>

            @if($loop->last)
                </tbody>
            </table>
            <div class="pres-table-footer">
                <span>Mostrando {{ $prestamosPasados->count() }} de {{ $prestamosPasados->total() }} en historial</span>
                {{ $prestamosPasados->appends(request()->query())->links() }}
            </div>
            @endif

        @empty
            <div class="pres-empty">No hay préstamos en el historial con los filtros aplicados.</div>
        @endforelse
    </div>

</div>

</x-layouts::app_administrador>