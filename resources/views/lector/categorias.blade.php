<x-layouts::app_lector>

{{-- Encabezado --}}
<div class="cat-page-header">
    <div>
        <h1 class="cat-page-title">Categorías</h1>
        <p class="cat-page-subtitle">
            Descubre las categorías de libros disponibles. Explora colecciones organizadas por temas, géneros o intereses para encontrar tu próxima lectura favorita.
        </p>
    </div>
</div>

{{-- Buscador --}}
<form method="GET" action="{{ route('lector.categorias.index') }}" class="cat-search-row">

    <input
        type="text"
        name="search"
        placeholder="Buscar categoría..."
        value="{{ request('search') }}"
        class="cat-search-input"
    >

    <button type="submit" class="cat-search-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
            viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="10" cy="10" r="7"/>
            <path d="M21 21l-6 -6"/>
        </svg>
    </button>

</form>

{{-- Grid --}}
<div class="cat-categorias-grid">

    @foreach ($categorias as $categoria)

        @php
            $imgs = array_values(array_filter($categoria->imagenes ?? []));
        @endphp

        <div class="cat-categoria-card">

            {{-- Carrusel --}}
            <div class="cat-carousel">

                @if (count($imgs) > 0)

                    <div
                        class="cat-carousel-track"
                        id="track-{{ $categoria->id }}"
                    >

                        @foreach ($imgs as $i => $imagen)

                            <div class="cat-carousel-slide">

                                <img
                                    src="{{ asset('storage/' . $imagen) }}"
                                    alt="{{ $categoria->nombre }}"
                                >

                            </div>

                        @endforeach

                    </div>

                    @if (count($imgs) > 1)

                        {{-- Flechas --}}
                        <button
                            class="cat-carousel-arrow cat-carousel-arrow--prev"
                            onclick="carouselMove('{{ $categoria->id }}', -1)"
                            type="button"
                        >
                            <svg width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M15 18l-6-6 6-6"/>
                            </svg>
                        </button>

                        <button
                            class="cat-carousel-arrow cat-carousel-arrow--next"
                            onclick="carouselMove('{{ $categoria->id }}', 1)"
                            type="button"
                        >
                            <svg width="16" height="16" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </button>

                        {{-- Dots --}}
                        <div
                            class="cat-carousel-dots"
                            id="dots-{{ $categoria->id }}"
                        >

                            @foreach ($imgs as $i => $imagen)

                                <button
                                    class="cat-carousel-dot {{ $i === 0 ? 'active' : '' }}"
                                    onclick="carouselGo('{{ $categoria->id }}', {{ $i }})"
                                    type="button"
                                ></button>

                            @endforeach

                        </div>

                        {{-- Counter --}}
                        <div class="cat-carousel-counter">
                            <span id="current-{{ $categoria->id }}">1</span>/{{ count($imgs) }}
                        </div>

                    @endif

                @else

                    <div class="cat-carousel-placeholder">

                        <svg xmlns="http://www.w3.org/2000/svg"
                            width="48" height="48"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1">

                            <path d="M15 8h.01"/>
                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                            <path d="M3 15l5-5c.928-.893 2.072-.893 3 0l5 5"/>
                            <path d="M14 14l1-1c.928-.893 2.072-.893 3 0l3 3"/>
                        </svg>

                        <span class="cat-carousel-placeholder-text">
                            Sin imágenes
                        </span>

                    </div>

                @endif

            </div>

            {{-- Body --}}
            <div class="cat-card-body">

                <div class="cat-card-title">
                    {{ $categoria->nombre }}
                </div>

                <div class="cat-card-subtitle">
                    {{ $categoria->descripcion }}
                </div>

                <div class="cat-card-meta">

                    <span class="cat-meta-count">

                        <svg width="14" height="14" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5">

                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                            <path d="M3 15l5-5c.928-.893 2.072-.893 3 0l5 5"/>
                            <path d="M14 14l1-1c.928-.893 2.072-.893 3 0l3 3"/>

                        </svg>

                        {{ count($imgs) }}
                        {{ count($imgs) === 1 ? 'imagen' : 'imágenes' }}

                    </span>

                </div>

            </div>

        </div>

    @endforeach

</div>

{{-- Modal --}}
<div id="modal-nueva" class="cat-modal-backdrop hidden">

    <div class="cat-modal">

        <div class="cat-modal-header">

            <h2>Nueva categoría</h2>

            <button
                class="cat-modal-close"
                type="button"
                onclick="document.getElementById('modal-nueva').classList.add('hidden')"
            >
                ✕
            </button>

        </div>

        <form
            method="POST"
            action="{{ route('admin.categorias.store') }}"
            enctype="multipart/form-data"
            class="cat-modal-form"
        >

            @csrf

            <div class="cat-form-group">

                <label class="cat-form-label">
                    Nombre
                </label>

                <input
                    type="text"
                    name="nombre"
                    class="cat-form-input"
                    required
                >

            </div>

            <div class="cat-form-group">

                <label class="cat-form-label">
                    Descripción
                </label>

                <input
                    type="text"
                    name="descripcion"
                    class="cat-form-input"
                    required
                >

            </div>

            <div class="cat-form-group">
                <label class="cat-form-label">Imágenes</label>

                <input
                    type="file"
                    name="imagenes[]"
                    id="cat-file-input"
                    multiple
                    accept="image/*"
                    required
                    style="display:none"
                    onchange="catHandleFileChange(this)"
                >

                <div
                    class="cat-file-dropzone"
                    id="cat-dropzone"
                    onclick="document.getElementById('cat-file-input').click()"
                    ondragover="event.preventDefault(); this.classList.add('cat-dragover')"
                    ondragleave="this.classList.remove('cat-dragover')"
                    ondrop="catHandleDrop(event)"
                >
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.25" stroke-linecap="round"
                            style="color:#9ca3af; flex-shrink:0">
                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                        <path d="M3 15l5-5c.928-.893 2.072-.893 3 0l5 5"/>
                        <path d="M14 14l1-1c.928-.893 2.072-.893 3 0l3 3"/>
                    </svg>
                    <span class="cat-dropzone-text"><strong>Haz clic para seleccionar</strong> o arrastra aquí</span>
                    <span class="cat-dropzone-hint">PNG, JPG, WEBP — varias a la vez</span>
                </div>

                <div class="cat-file-preview" id="cat-file-preview"></div>
            </div>

            <div class="cat-modal-footer">

                <button
                    type="button"
                    class="cat-btn-cancel"
                    onclick="document.getElementById('modal-nueva').classList.add('hidden')"
                >
                    Cancelar
                </button>

                <button
                    type="submit"
                    class="cat-btn-submit"
                >
                    Crear categoría
                </button>

            </div>

        </form>

    </div>

</div>

<script>
/* ── Carrusel ── */
const carouselState = {};

function carouselMove(id, dir) {
    const track = document.getElementById('track-' + id);
    const slides = track.querySelectorAll('.cat-carousel-slide');
    const total = slides.length;
    if (carouselState[id] === undefined) carouselState[id] = 0;
    carouselState[id] = (carouselState[id] + dir + total) % total;
    track.style.transform = `translateX(-${carouselState[id] * 100}%)`;
    updateDots(id, carouselState[id]);
}

function carouselGo(id, index) {
    const track = document.getElementById('track-' + id);
    carouselState[id] = index;
    track.style.transform = `translateX(-${index * 100}%)`;
    updateDots(id, index);
}

function updateDots(id, current) {
    const container = document.getElementById('dots-' + id);
    if (container) {
        container.querySelectorAll('.cat-carousel-dot').forEach((dot, i) => {
            dot.classList.toggle('active', i === current);
        });
    }
    const counter = document.getElementById('current-' + id);
    if (counter) counter.textContent = current + 1;
}
</script>

</x-layouts::app_lector>