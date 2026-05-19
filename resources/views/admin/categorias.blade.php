<x-layouts::app_administrador>

{{-- Encabezado --}}
<div class="cat-page-header">
    <div>
        <h1 class="cat-page-title">Categorías</h1>
        <p class="cat-page-subtitle">
            Gestiona la colección de categorías y sus imágenes.
        </p>
    </div>

    <button
        class="cat-btn-new"
        onclick="document.getElementById('modal-nueva').classList.remove('hidden')"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
            viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 19h-7a2 2 0 0 1 -2 -2v-11a2 2 0 0 1 2 -2h4l3 3h7a2 2 0 0 1 2 2v3.5"/>
            <path d="M16 19h6m-3 -3v6"/>
        </svg>

        Nueva categoría
    </button>
</div>

{{-- Buscador --}}
<form method="GET" action="{{ route('categorias.index') }}" class="cat-search-row">

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

                {{-- Actions --}}
                <div class="cat-card-actions">

                    <a
                        href="{{ route('categorias.edit', $categoria->id) }}"
                        class="cat-action-btn"
                    >
                        Editar
                    </a>

                    <form
                        method="POST"
                        action="{{ route('categorias.destroy', $categoria->id) }}"
                        class="cat-inline-form"
                        onsubmit="return confirm('¿Eliminar categoría?')"
                    >

                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="cat-action-btn cat-action-btn--danger"
                        >
                            Eliminar
                        </button>

                    </form>

                </div>

            </div>

        </div>

    @endforeach

    {{-- Agregar --}}
    <div
        class="cat-add-card"
        onclick="document.getElementById('modal-nueva').classList.remove('hidden')"
    >

        <div class="cat-add-icon">
            +
        </div>

        <div class="cat-add-title">
            Agregar categoría
        </div>

        <div class="cat-add-desc">
            Conecta una nueva colección
        </div>

    </div>

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
            action="{{ route('categorias.store') }}"
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

/* ── Dropzone / file preview ── */
let catSelectedFiles = [];

function catHandleFileChange(input) {
    catSelectedFiles = Array.from(input.files);
    catRenderPreview();
}

function catHandleDrop(event) {
    event.preventDefault();
    document.getElementById('cat-dropzone').classList.remove('cat-dragover');
    const dt = event.dataTransfer;
    if (dt && dt.files.length) {
        catSelectedFiles = Array.from(dt.files).filter(f => f.type.startsWith('image/'));
        catUpdateFileInput();
        catRenderPreview();
    }
}

function catRemoveFile(index) {
    catSelectedFiles.splice(index, 1);
    catUpdateFileInput();
    catRenderPreview();
}

function catUpdateFileInput() {
    const input = document.getElementById('cat-file-input');
    const dt = new DataTransfer();
    catSelectedFiles.forEach(f => dt.items.add(f));
    input.files = dt.files;
}

function catRenderPreview() {
    const container = document.getElementById('cat-file-preview');
    container.innerHTML = '';
    if (catSelectedFiles.length === 0) return;

    catSelectedFiles.forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const thumb = document.createElement('div');
            thumb.className = 'cat-preview-thumb';
            thumb.innerHTML = `
                <img src="${e.target.result}" alt="${file.name}">
                <button type="button" onclick="catRemoveFile(${i})" title="Quitar">✕</button>
            `;
            container.insertBefore(thumb, container.lastElementChild || null);
        };
        reader.readAsDataURL(file);
    });

    const count = document.createElement('span');
    count.className = 'cat-preview-count';
    const n = catSelectedFiles.length;
    count.textContent = n + ' archivo' + (n !== 1 ? 's' : '') + ' seleccionado' + (n !== 1 ? 's' : '');
    container.appendChild(count);
}
</script>

</x-layouts::app_administrador>