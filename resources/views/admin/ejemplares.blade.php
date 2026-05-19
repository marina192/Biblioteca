<x-layouts::app_administrador>

{{-- Encabezado --}}
<div class="ejmp-page-header">
    <div>
        <h1 class="ejmp-page-title">Ejemplares</h1>
        <p class="ejmp-page-subtitle">Gestiona los ejemplares físicos de cada libro.</p>
    </div>
    <button class="ejmp-btn-new" onclick="document.getElementById('ejmp-modal-nuevo').classList.remove('hidden')">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.5" stroke-linecap="round">
            <path d="M12 5v14M5 12h14"/>
        </svg>
        Nuevo ejemplar
    </button>
</div>

{{-- Buscador --}}
<form method="GET" action="{{ route('admin.ejemplares.index') }}" class="ejmp-search-row">
    <div class="ejmp-search-input-wrap">
        <svg class="ejmp-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.75" stroke-linecap="round">
            <circle cx="10" cy="10" r="7"/>
            <path d="M21 21l-6-6"/>
        </svg>
        <input
            type="text"
            name="search"
            placeholder="Buscar por ID o nombre del libro..."
            value="{{ request('search') }}"
            class="ejmp-search-input"
        >
        @if(request('search'))
            <a href="{{ route('admin.ejemplares.index') }}" class="ejmp-search-clear" title="Limpiar búsqueda">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
            </a>
        @endif
    </div>
    <button type="submit" class="ejmp-search-btn">Buscar</button>
</form>

{{-- Tablas agrupadas por libro --}}
@forelse($ejemplares->groupBy('libro_id') as $libroId => $grupo)

    <div class="ejmp-group">

        {{-- Cabecera del grupo --}}
        <div class="ejmp-group-header">
            <div class="ejmp-group-header-left">
                <span class="ejmp-group-id">#{{ $grupo->first()->libro->id }}</span>
                <h2 class="ejmp-group-title">{{ $grupo->first()->libro->titulo }}</h2>
            </div>
            <span class="ejmp-group-badge">
                {{ $grupo->count() }} ejemplar{{ $grupo->count() !== 1 ? 'es' : '' }}
            </span>
        </div>

        {{-- Tabla --}}
        <div class="ejmp-table-wrap">
            <table class="ejmp-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Libro</th>
                        <th>Estado</th>
                        <th>Ubicación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grupo as $ejemplar)
                        <tr>
                            <td>
                                <span class="ejmp-id-badge">{{ $ejemplar->id }}</span>
                            </td>
                            <td class="ejmp-td-libro">{{ $ejemplar->libro->titulo }}</td>
                            <td>
                                <span class="ejmp-estado-badge ejmp-estado--{{ $ejemplar->estado }}">
                                    @if($ejemplar->estado === 'disponible')
                                        <span class="ejmp-estado-dot"></span> Disponible
                                    @elseif($ejemplar->estado === 'prestado')
                                        <span class="ejmp-estado-dot"></span> Prestado
                                    @elseif($ejemplar->estado === 'dañado')
                                        <span class="ejmp-estado-dot"></span> Dañado
                                    @else
                                        {{ $ejemplar->estado }}
                                    @endif
                                </span>
                            </td>
                            <td class="ejmp-td-ubicacion">{{ $ejemplar->ubicacion }}</td>
                            <td>
                                <div class="ejmp-actions">
                                    <a href="{{ route('admin.ejemplares.edit', $ejemplar->id) }}" class="ejmp-action-btn">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="1.75" stroke-linecap="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                        </svg>
                                        Editar
                                    </a>
                                    <form action="{{ route('admin.ejemplares.destroy', $ejemplar->id) }}" method="POST"
                                            class="ejmp-inline-form"
                                            onsubmit="return confirm('¿Eliminar este ejemplar?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="ejmp-action-btn ejmp-action-btn--danger">
                                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="1.75" stroke-linecap="round">
                                                <path d="M4 7h16M10 11v6M14 11v6"/>
                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12"/>
                                                <path d="M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/>
                                            </svg>
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

@empty
    <div class="ejmp-empty">
        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1" style="opacity:0.25">
            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
        </svg>
        <p class="ejmp-empty-text">
            @if(request('search'))
                No se encontraron ejemplares para <strong>"{{ request('search') }}"</strong>
            @else
                No hay ejemplares registrados aún.
            @endif
        </p>
        @if(request('search'))
            <a href="{{ route('admin.ejemplares.index') }}" class="ejmp-empty-link">Ver todos los ejemplares</a>
        @endif
    </div>
@endforelse

{{-- Paginación --}}
<div class="ejmp-pagination">
    {{ $ejemplares->appends(request()->query())->links() }}
</div>

{{-- Modal nuevo ejemplar --}}
<div id="ejmp-modal-nuevo" class="ejmp-modal-backdrop hidden">
    <div class="ejmp-modal">
        <div class="ejmp-modal-header">
            <h2>Nuevo ejemplar</h2>
            <button class="ejmp-modal-close" type="button"
                    onclick="document.getElementById('ejmp-modal-nuevo').classList.add('hidden')">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.ejemplares.store') }}" enctype="multipart/form-data"
                class="ejmp-modal-form">
            @csrf

            <div class="ejmp-form-group">
                <label class="ejmp-form-label" for="libro_id">Libro</label>
                <select id="libro_id" name="libro_id" class="ejmp-form-input" required>
                    <option value="">Selecciona un libro</option>
                    @foreach($libros as $libro)
                        <option value="{{ $libro->id }}" {{ old('libro_id') == $libro->id ? 'selected' : '' }}>
                            {{ $libro->titulo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="ejmp-form-group">
                <label class="ejmp-form-label" for="estado">Estado</label>
                <select id="estado" name="estado" class="ejmp-form-input" required>
                    <option value="">Selecciona un estado</option>
                    <option value="disponible" {{ old('estado') === 'disponible' ? 'selected' : '' }}>Disponible</option>
                    <option value="prestado"   {{ old('estado') === 'prestado'   ? 'selected' : '' }}>Prestado</option>
                    <option value="dañado"     {{ old('estado') === 'dañado'     ? 'selected' : '' }}>Dañado</option>
                </select>
            </div>

            <div class="ejmp-form-group">
                <label class="ejmp-form-label" for="ubicacion">Ubicación</label>
                <input type="text" id="ubicacion" name="ubicacion"
                    value="{{ old('ubicacion') }}"
                    placeholder="Ej. Estante A-3"
                    class="ejmp-form-input" required>
            </div>

            <div class="ejmp-modal-footer">
                <button type="button" class="ejmp-btn-cancel"
                        onclick="document.getElementById('ejmp-modal-nuevo').classList.add('hidden')">
                    Cancelar
                </button>
                <button type="submit" class="ejmp-btn-submit">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Agregar ejemplar
                </button>
            </div>
        </form>
    </div>
</div>

</x-layouts::app_administrador>