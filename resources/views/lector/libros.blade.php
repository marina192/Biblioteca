<x-layouts::app_lector>

{{-- Encabezado --}}
<div class="libros-page-header">
    <div>
        <h1 class="libros-page-title">Libros</h1>
        <p class="libros-page-subtitle">Gestiona la colección de libros y sus registros.</p>
    </div>
</div>

{{-- Filtros de categoría --}}
<div class="libros-filters-row">

    {{-- Botón Todos --}}
    <a href="{{ route('lector.libros.index') }}"
        class="libros-filter-btn {{ !request()->has('categorias') ? 'active' : '' }}">
        Todos
    </a>

    @foreach ($categorias as $cat)

        @php
            $categoriasSeleccionadas = request()->input('categorias', []);
            $activo = in_array($cat->id, $categoriasSeleccionadas);
        @endphp

        <a href="{{ route('lector.libros.index', [
                'categorias' => $activo
                    ? array_diff($categoriasSeleccionadas, [$cat->id]) // quitar
                    : array_merge($categoriasSeleccionadas, [$cat->id]) // agregar
            ]) }}"
            class="libros-filter-btn {{ $activo ? 'active' : '' }}">
            {{ $cat->nombre }}
        </a>

    @endforeach
</div>

{{-- Buscador --}}
<form method="GET" action="{{ route('lector.libros.index') }}" class="libros-search-row">
    @if (request('categoria'))
        <input type="hidden" name="categoria" value="{{ request('categoria') }}">
    @endif
    <input
        type="text"
        name="search"
        placeholder="Buscar libro..."
        value="{{ request('search') }}"
        class="libros-search-input"
    >
    <button type="submit" class="libros-search-btn">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
            <circle cx="10" cy="10" r="7"/>
            <path d="M21 21l-6-6"/>
        </svg>
    </button>
</form>

{{-- Grid de tarjetas --}}
<div class="libros-grid">

    @foreach ($libros as $libro)
        @php $imgs = array_values(array_filter($libro->imagenes ?? [])); @endphp
        <div class="libros-libro-card">

            {{-- Carrusel --}}
            <div class="libros-carousel" id="libros-carousel-{{ $libro->id }}">
                @if (count($imgs) > 0)
                    <div class="libros-carousel-track" id="track-{{ $libro->id }}">
                        @foreach ($imgs as $i => $imagen)
                            <div class="libros-carousel-slide">
                                <img src="{{ asset('storage/' . $imagen) }}"
                                    alt="{{ $libro->titulo }} imagen {{ $i + 1 }}">
                            </div>
                        @endforeach
                    </div>
                    @if (count($imgs) > 1)
                        {{-- ↓ CORRECCIÓN: librosCarouselMove sin guiones --}}
                        <button class="libros-carousel-arrow libros-carousel-arrow--prev"
                                onclick="librosCarouselMove('{{ $libro->id }}', -1)" aria-label="Anterior">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                <path d="M15 18l-6-6 6-6"/>
                            </svg>
                        </button>
                        <button class="libros-carousel-arrow libros-carousel-arrow--next"
                                onclick="librosCarouselMove('{{ $libro->id }}', 1)" aria-label="Siguiente">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </button>
                        <div class="libros-carousel-dots" id="dots-{{ $libro->id }}">
                            @foreach ($imgs as $i => $imagen)
                                {{-- ↓ CORRECCIÓN: librosCarouselGo sin guiones --}}
                                <button class="libros-carousel-dot {{ $i === 0 ? 'active' : '' }}"
                                        onclick="librosCarouselGo('{{ $libro->id }}', {{ $i }})"
                                        aria-label="Imagen {{ $i + 1 }}"></button>
                            @endforeach
                        </div>
                        <div class="libros-carousel-counter">
                            <span id="current-{{ $libro->id }}">1</span>/{{ count($imgs) }}
                        </div>
                    @endif
                @else
                    <div class="libros-carousel-placeholder">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1" style="opacity:0.25">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                        </svg>
                        <span class="libros-carousel-placeholder-text">Sin imágenes</span>
                    </div>
                @endif
            </div>

            {{-- Cuerpo --}}
            <div class="libros-card-body">
                <div class="libros-card-title">{{ $libro->titulo }}</div>
                <div class="libros-card-author">{{ $libro->autor }}</div>

                @if ($libro->categorias->count() > 0)
                    <div class="libros-tags">
                        @foreach ($libro->categorias as $cat)
                            <span class="libros-tag">{{ $cat->nombre }}</span>
                        @endforeach
                    </div>
                @endif

                <div class="libros-card-meta">
                    <span class="libros-meta-item">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="4" width="18" height="18" rx="2"/>
                            <path d="M16 2v4M8 2v4M3 10h18"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($libro->fecha_publicacion)->format('d/m/Y') }}
                    </span>
                    <span class="libros-meta-item">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.5">
                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/>
                        </svg>
                        {{ $libro->editorial }}
                    </span>
                    {{-- ↓ NUEVO: Ejemplares disponibles --}}
                    @php $disponibles = $libro->ejemplares->where('estado', 'disponible')->count(); @endphp
                    <span class="libros-meta-item">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.5">
                            <path d="M20 7H4a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z"/>
                            <path d="M16 3H8a2 2 0 0 0-2 2v2h12V5a2 2 0 0 0-2-2z"/>
                        </svg>
                        <span class="{{ $disponibles > 0 ? 'libros-disponibles' : 'libros-no-disponibles' }}">
                            {{ $disponibles }} {{ $disponibles === 1 ? 'ejemplar disponible' : 'ejemplares disponibles' }}
                        </span>
                    </span>
                </div>

                <div class="libros-card-actions">
                    {{-- ↓ NUEVO: Botón Ver más --}}
                    <a href="{{ route('lector.libros.show', $libro) }}" class="libros-action-btn libros-action-btn--primary">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round">
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/>
                        </svg>
                        Ver más
                    </a>
                </div>
            </div>

        </div>
    @endforeach

</div>

<script>
// ── Carrusel ──
const librosCarouselState = {};

function librosCarouselMove(id, dir) {
    const track = document.getElementById('track-' + id);
    const total = track.querySelectorAll('.libros-carousel-slide').length;
    if (librosCarouselState[id] === undefined) librosCarouselState[id] = 0;
    librosCarouselState[id] = (librosCarouselState[id] + dir + total) % total;
    track.style.transform = `translateX(-${librosCarouselState[id] * 100}%)`;
    librosUpdateDots(id, librosCarouselState[id]);
}

function librosCarouselGo(id, index) {
    const track = document.getElementById('track-' + id);
    librosCarouselState[id] = index;
    track.style.transform = `translateX(-${index * 100}%)`;
    librosUpdateDots(id, index);
}

function librosUpdateDots(id, current) {
    const container = document.getElementById('dots-' + id);
    if (container) {
        container.querySelectorAll('.libros-carousel-dot').forEach((dot, i) => {
            dot.classList.toggle('active', i === current);
        });
    }
    const counter = document.getElementById('current-' + id);
    if (counter) counter.textContent = current + 1;
}

</script>

</x-layouts::app_lector>