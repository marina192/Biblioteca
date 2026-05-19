<x-layouts::app_administrador>

{{-- Encabezado --}}
<div class="libros-page-header">
    <div>
        <h1 class="libros-page-title">Libros</h1>
        <p class="libros-page-subtitle">Gestiona la colección de libros y sus registros.</p>
    </div>
    <button class="libros-btn-new" onclick="document.getElementById('libros-modal-nuevo').classList.remove('hidden')">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="1.5" stroke-linecap="round">
            <path d="M12 5v14M5 12h14"/>
        </svg>
        Nuevo libro
    </button>
</div>

{{-- Filtros de categoría --}}
<div class="libros-filters-row">
    <a href="{{ route('admin.libros.index') }}"
        class="libros-filter-btn {{ !request('categoria') ? 'active' : '' }}">
        Todos
    </a>
    @foreach ($categorias as $cat)
        <a href="{{ route('admin.libros.index', ['categoria' => $cat->id]) }}"
            class="libros-filter-btn {{ request('categoria') == $cat->id ? 'active' : '' }}">
            {{ $cat->nombre }}
        </a>
    @endforeach
</div>

{{-- Buscador --}}
<form method="GET" action="{{ route('admin.libros.index') }}" class="libros-search-row">
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
                </div>

                <div class="libros-card-actions">
                    <a href="{{ route('admin.libros.edit', $libro->id) }}" class="libros-action-btn">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                        </svg>
                        Editar
                    </a>
                    <form method="POST" action="{{ route('admin.libros.destroy', $libro->id) }}"
                            class="libros-inline-form"
                            onsubmit="return confirm('¿Eliminar este libro?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="libros-action-btn libros-action-btn--danger">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                                <path d="M4 7h16M10 11v6M14 11v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12"/>
                                <path d="M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/>
                            </svg>
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>

        </div>
    @endforeach

    {{-- Tarjeta agregar --}}
    <div class="libros-add-card"
            onclick="document.getElementById('libros-modal-nuevo').classList.remove('hidden')"
            role="button" tabindex="0">
        <div class="libros-add-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                <path d="M12 5v14M5 12h14"/>
            </svg>
        </div>
        <div class="libros-add-title">Agregar libro</div>
        <div class="libros-add-desc">Registra un nuevo volumen en la biblioteca</div>
    </div>

</div>

{{-- Modal de creación --}}
<div id="libros-modal-nuevo" class="libros-modal-backdrop hidden">
    <div class="libros-modal">
        <div class="libros-modal-header">
            <h2>Nuevo libro</h2>
            <button class="libros-modal-close"
                    onclick="document.getElementById('libros-modal-nuevo').classList.add('hidden')">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.libros.store') }}"
                enctype="multipart/form-data" class="libros-modal-form">
            @csrf

            <div class="libros-modal-grid">
                <div class="libros-form-group">
                    <label class="libros-form-label">Título</label>
                    <input type="text" name="titulo" class="libros-form-input"
                        placeholder="Título del libro" required>
                </div>
                <div class="libros-form-group">
                    <label class="libros-form-label">Autor</label>
                    <input type="text" name="autor" class="libros-form-input"
                        placeholder="Nombre del autor" required>
                </div>
                <div class="libros-form-group">
                    <label class="libros-form-label">Editorial</label>
                    <input type="text" name="editorial" class="libros-form-input"
                        placeholder="Editorial" required>
                </div>
                <div class="libros-form-group">
                    <label class="libros-form-label">Fecha de publicación</label>
                    <input type="date" name="fecha_publicacion" class="libros-form-input" required>
                </div>
            </div>

            <div class="libros-form-group">
                <label class="libros-form-label">Categorías</label>
                <div class="libros-checkboxes-grid">
                    @foreach ($categorias as $cat)
                        <label class="libros-checkbox-item">
                            <input type="checkbox" name="categorias[]" value="{{ $cat->id }}">
                            <span>{{ $cat->nombre }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="libros-form-group">
                <label class="libros-form-label">Imágenes</label>
                <input type="file" name="imagenes[]" id="libros-file-input"
                    multiple accept="image/*" required style="display:none"
                    onchange="librosHandleFileChange(this)">
                <div class="libros-file-dropzone" id="libros-dropzone"
                        onclick="document.getElementById('libros-file-input').click()"
                        ondragover="event.preventDefault();this.classList.add('libros-dragover')"
                        ondragleave="this.classList.remove('libros-dragover')"
                        ondrop="librosHandleDrop(event)">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.25" style="color:#9ca3af">
                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                        <path d="M3 15l5-5c.928-.893 2.072-.893 3 0l5 5"/>
                        <path d="M14 14l1-1c.928-.893 2.072-.893 3 0l3 3"/>
                    </svg>
                    <span class="libros-dropzone-text"><strong>Haz clic para seleccionar</strong> o arrastra aquí</span>
                    <span class="libros-dropzone-hint">PNG, JPG, WEBP — varias a la vez</span>
                </div>
                <div class="libros-file-preview" id="libros-preview"></div>
            </div>

            <div class="libros-modal-footer">
                <button type="button" class="libros-btn-cancel"
                        onclick="document.getElementById('libros-modal-nuevo').classList.add('hidden')">
                    Cancelar
                </button>
                <button type="submit" class="libros-btn-submit">Crear libro</button>
            </div>
        </form>
    </div>
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

// ── Dropzone / preview ──
let librosSelectedFiles = [];

function librosHandleFileChange(input) {
    librosSelectedFiles = Array.from(input.files);
    librosRenderPreview();
}

function librosHandleDrop(event) {
    event.preventDefault();
    document.getElementById('libros-dropzone').classList.remove('libros-dragover');
    const dt = event.dataTransfer;
    if (dt && dt.files.length) {
        librosSelectedFiles = Array.from(dt.files).filter(f => f.type.startsWith('image/'));
        librosUpdateFileInput();
        librosRenderPreview();
    }
}

function librosRemoveFile(index) {
    librosSelectedFiles.splice(index, 1);
    librosUpdateFileInput();
    librosRenderPreview();
}

function librosUpdateFileInput() {
    const input = document.getElementById('libros-file-input');
    const dt = new DataTransfer();
    librosSelectedFiles.forEach(f => dt.items.add(f));
    input.files = dt.files;
}

function librosRenderPreview() {
    const container = document.getElementById('libros-preview');
    container.innerHTML = '';
    if (librosSelectedFiles.length === 0) return;

    const count = document.createElement('span');
    count.className = 'libros-preview-count';
    const n = librosSelectedFiles.length;
    count.textContent = n + ' archivo' + (n !== 1 ? 's' : '') + ' seleccionado' + (n !== 1 ? 's' : '');
    container.appendChild(count);

    librosSelectedFiles.forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const thumb = document.createElement('div');
            thumb.className = 'libros-preview-thumb';
            thumb.innerHTML = `
                <img src="${e.target.result}" alt="${file.name}">
                <button type="button" onclick="librosRemoveFile(${i})" title="Quitar">✕</button>
            `;
            container.insertBefore(thumb, count);
        };
        reader.readAsDataURL(file);
    });
}
</script>

</x-layouts::app_administrador>