<x-layouts::app_administrador>
 
{{-- Encabezado --}}
<div class="cat-page-header">
    <div>
        <h1 class="cat-page-title">Categorías</h1>
        <p class="cat-page-subtitle">Gestiona la colección de categorías y sus imágenes.</p>
    </div>
    <button
        class="cat-btn-new"
        onclick="document.getElementById('modal-nueva').classList.remove('hidden')"
    >
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
             stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
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
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
             stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <circle cx="10" cy="10" r="7"/>
            <path d="M21 21l-6 -6"/>
        </svg>
    </button>
</form>
 
{{-- Grid de tarjetas --}}
<div class="cat-categorias-grid">
 
    @foreach ($categorias as $categoria)
        @php $imgs = array_values(array_filter($categoria->imagenes ?? [])); @endphp
        <div class="cat-categoria-card">
 
            {{-- Carrusel de imágenes --}}
            <div class="cat-carousel" id="carousel-{{ $categoria->id }}">
 
                @if (count($imgs) > 0)
 
                    <div class="cat-cat-carousel-track" id="track-{{ $categoria->id }}">
                        @foreach ($imgs as $i => $imagen)
                            <div class="cat-cat-carousel-slide">
                                <img
                                    src="{{ asset('storage/' . $imagen) }}"
                                    alt="{{ $categoria->nombre }} imagen {{ $i + 1 }}"
                                >
                            </div>
                        @endforeach
                    </div>
 
                    @if (count($imgs) > 1)
                        <button
                            class="cat-cat-carousel-arrow cat-cat-cat-carousel-arrow--prev"
                            onclick="carouselMove('{{ $categoria->id }}', -1)"
                            aria-label="Anterior"
                        >
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                <path d="M15 18l-6-6 6-6"/>
                            </svg>
                        </button>
                        <button
                            class="cat-cat-carousel-arrow cat-cat-cat-carousel-arrow--next"
                            onclick="carouselMove('{{ $categoria->id }}', 1)"
                            aria-label="Siguiente"
                        >
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="2" stroke-linecap="round">
                                <path d="M9 18l6-6-6-6"/>
                            </svg>
                        </button>
 
                        <div class="cat-cat-carousel-dots" id="dots-{{ $categoria->id }}">
                            @foreach ($imgs as $i => $imagen)
                                <button
                                    class="cat-cat-carousel-dot {{ $i === 0 ? 'active' : '' }}"
                                    onclick="carouselGo('{{ $categoria->id }}', {{ $i }}, {{ count($imgs) }})"
                                    aria-label="Imagen {{ $i + 1 }}"
                                ></button>
                            @endforeach
                        </div>
 
                        <div class="cat-cat-carousel-counter">
                            <span id="current-{{ $categoria->id }}">1</span>/{{ count($imgs) }}
                        </div>
                    @endif
 
                @else
                    <div class="cat-cat-carousel-placeholder">
                        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                             stroke-linejoin="round" style="opacity:0.25">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M15 8h.01"/>
                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                            <path d="M3 15l5-5c.928-.893 2.072-.893 3 0l5 5"/>
                            <path d="M14 14l1-1c.928-.893 2.072-.893 3 0l3 3"/>
                        </svg>
                        <span class="cat-cat-cat-carousel-placeholder-text">Sin imágenes</span>
                    </div>
                @endif
 
            </div>
 
            {{-- Cuerpo --}}
            <div class="cat-card-body">
                <div class="cat-card-title">{{ $categoria->nombre }}</div>
                <div class="cat-card-subtitle">{{ $categoria->descripcion }}</div>
 
                <div class="cat-card-meta">
                    <span class="cat-meta-count">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.5">
                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                            <path d="M3 15l5-5c.928-.893 2.072-.893 3 0l5 5"/>
                            <path d="M14 14l1-1c.928-.893 2.072-.893 3 0l3 3"/>
                        </svg>
                        {{ count($imgs) }} {{ count($imgs) === 1 ? 'imagen' : 'imágenes' }}
                    </span>
                </div>
 
                <div class="cat-card-actions">
                    <a href="{{ route('categorias.edit', $categoria->id) }}" class="cat-action-btn" title="Editar">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                            <path d="M7 7h-1a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-1"/>
                            <path d="M20.385 6.585a2.1 2.1 0 0 0-2.97-2.97l-8.415 8.385v3h3l8.385-8.415z"/>
                        </svg>
                        Editar
                    </a>
                    <form
                        method="POST"
                        action="{{ route('categorias.destroy', $categoria->id) }}"
                        class="cat-inline-form"
                        onsubmit="return confirm('¿Eliminar esta categoría?')"
                    >
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="cat-action-btn cat-cat-action-btn--danger" title="Eliminar">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                                <path d="M4 7l16 0"/><path d="M10 11l0 6"/><path d="M14 11l0 6"/>
                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12"/>
                                <path d="M9 7v-3a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/>
                            </svg>
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
 
        </div>
    @endforeach
 
    {{-- Tarjeta agregar --}}
    <div
        class="cat-add-card"
        onclick="document.getElementById('modal-nueva').classList.remove('hidden')"
        role="button"
        tabindex="0"
    >
        <div class="cat-add-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                <path d="M12 5v14M5 12h14"/>
            </svg>
        </div>
        <div class="cat-add-title">Agregar categoría</div>
        <div class="cat-add-desc">Conecta una nueva colección a la biblioteca</div>
    </div>
 
</div>
 
{{-- Modal --}}
<div id="modal-nueva" class="cat-cat-modal-backdrop hidden">
    <div class="cat-modal">
        <div class="cat-cat-modal-header">
            <h2>Nueva categoría</h2>
            <button
                class="cat-cat-modal-close"
                onclick="document.getElementById('modal-nueva').classList.add('hidden')"
            >
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round">
                    <path d="M18 6L6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>
 
        <form
            method="POST"
            action="{{ route('categorias.store') }}"
            enctype="multipart/form-data"
            class="cat-cat-modal-form"
        >
            @csrf
 
            <div class="cat-form-group">
                <label class="cat-form-label">Nombre</label>
                <input type="text" name="nombre" class="cat-form-input"
                       placeholder="Nombre de la categoría" required>
            </div>
 
            <div class="cat-form-group">
                <label class="cat-form-label">Descripción</label>
                <input type="text" name="descripcion" class="cat-form-input"
                       placeholder="Breve descripción" required>
            </div>
 
            <div class="cat-form-group">
                <label class="cat-form-label">Imágenes</label>
 
                <input
                    type="file"
                    name="imagenes[]"
                    id="file-input"
                    multiple
                    accept="image/*"
                    required
                    style="display:none"
                    onchange="handleFileChange(this)"
                >
 
                <div
                    class="cat-file-dropzone"
                    id="dropzone"
                    onclick="document.getElementById('file-input').click()"
                    ondragover="event.preventDefault(); this.classList.add('cat-dragover')"
                    ondragleave="this.classList.remove('cat-dragover')"
                    ondrop="handleDrop(event)"
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
 
                <div class="cat-file-preview" id="file-preview"></div>
            </div>
 
            <div class="cat-cat-modal-footer">
                <button type="button" class="cat-btn-cancel"
                        onclick="document.getElementById('modal-nueva').classList.add('hidden')">
                    Cancelar
                </button>
                <button type="submit" class="cat-btn-submit">Crear categoría</button>
            </div>
        </form>
    </div>
</div>
 
<style>
.cat-page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.75rem;
    gap: 1rem;
}
.cat-page-title {
    font-size: 2rem;
    font-weight: 700;
    color: #111827;
    margin: 0;
    letter-spacing: -0.5px;
}
.cat-page-subtitle {
    font-size: 0.9375rem;
    color: #6b7280;
    margin: 5px 0 0;
}
.cat-btn-new {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #fff;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    padding: 10px 18px;
    font-size: 0.9375rem;
    font-weight: 500;
    cursor: pointer;
    color: #111827;
    text-decoration: none;
    white-space: nowrap;
    transition: background 0.15s;
}
.cat-btn-new:hover { background: #f9fafb; }
.cat-search-row {
    display: flex;
    gap: 8px;
    margin-bottom: 2rem;
}
.cat-search-input {
    flex: 1;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    padding: 10px 16px;
    font-size: 0.9375rem;
    color: #111827;
    background: #fff;
    outline: none;
    transition: border-color 0.15s;
}
.cat-search-input:focus { border-color: #1D9E75; }
.cat-search-btn {
    border: 1px solid #d1d5db;
    border-radius: 10px;
    padding: 10px 14px;
    background: #fff;
    cursor: pointer;
    color: #6b7280;
    display: flex;
    align-items: center;
    transition: background 0.15s;
}
.cat-search-btn:hover { background: #f9fafb; color: #111827; }
.cat-categorias-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
}
.cat-categoria-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 14px;
    overflow: hidden;
    transition: box-shadow 0.2s, transform 0.2s;
}
.cat-categoria-card:hover {
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    transform: translateY(-2px);
}
.cat-carousel {
    position: relative;
    width: 100%;
    height: 220px;
    overflow: hidden;
    background: #f3f4f6;
}
.cat-carousel-track {
    display: flex;
    height: 100%;
    transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}
.cat-carousel-slide {
    min-width: 100%;
    height: 100%;
    flex-shrink: 0;
}
.cat-carousel-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.cat-carousel-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.cat-carousel-placeholder-text {
    font-size: 0.8125rem;
    color: #9ca3af;
}
.cat-carousel-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255,255,255,0.88);
    border: none;
    border-radius: 50%;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #374151;
    opacity: 0;
    transition: opacity 0.2s;
    z-index: 2;
}
.cat-carousel:hover .cat-carousel-arrow { opacity: 1; }
.cat-carousel-arrow:hover { background: #fff; }
.cat-carousel-arrow--prev { left: 10px; }
.cat-carousel-arrow--next { right: 10px; }
.cat-carousel-dots {
    position: absolute;
    bottom: 10px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 5px;
    z-index: 2;
}
.cat-carousel-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: rgba(255,255,255,0.55);
    border: none;
    cursor: pointer;
    padding: 0;
    transition: background 0.2s, transform 0.2s;
}
.cat-carousel-dot.active { background: #fff; transform: scale(1.3); }
.cat-carousel-counter {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(0,0,0,0.45);
    color: #fff;
    font-size: 0.75rem;
    padding: 2px 8px;
    border-radius: 999px;
    z-index: 2;
}
.cat-card-body { padding: 16px 18px 18px; }
.cat-card-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: #111827;
    margin: 0 0 4px;
    line-height: 1.3;
}
.cat-card-subtitle {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0 0 12px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.cat-card-meta { margin-bottom: 14px; }
.cat-meta-count {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 0.8125rem;
    color: #9ca3af;
}
.cat-card-actions {
    display: flex;
    gap: 8px;
    border-top: 1px solid #f3f4f6;
    padding-top: 12px;
}
.cat-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: none;
    border: 1px solid #e5e7eb;
    cursor: pointer;
    color: #374151;
    padding: 7px 14px;
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 500;
    text-decoration: none;
    transition: background 0.15s, border-color 0.15s;
}
.cat-action-btn:hover { background: #f9fafb; border-color: #d1d5db; }
.cat-action-btn--danger { color: #6b7280; }
.cat-action-btn--danger:hover { background: #fee2e2; border-color: #fca5a5; color: #dc2626; }
.cat-inline-form { display: inline; }
.cat-add-card {
    background: #fff;
    border: 1.5px dashed #d1d5db;
    border-radius: 14px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 320px;
    cursor: pointer;
    gap: 12px;
    transition: background 0.15s, border-color 0.15s;
}
.cat-add-card:hover { background: #f9fafb; border-color: #1D9E75; }
.cat-add-card:hover .cat-add-icon { border-color: #1D9E75; color: #1D9E75; }
.cat-add-icon {
    width: 40px;
    height: 40px;
    border: 1.5px solid #d1d5db;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    transition: border-color 0.15s, color 0.15s;
}
.cat-add-title { font-size: 1.0625rem; font-weight: 600; color: #374151; text-align: center; }
.cat-add-desc { font-size: 0.875rem; color: #9ca3af; text-align: center; padding: 0 20px; }
.cat-modal-backdrop {
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 50;
}
.cat-modal-backdrop.hidden { display: none; }
.cat-modal {
    background: #fff;
    border-radius: 14px;
    width: 100%;
    max-width: 460px;
    padding: 1.75rem;
    margin: 1rem;
}
.cat-modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}
.cat-modal-header h2 { font-size: 1.25rem; font-weight: 600; margin: 0; color: #111827; }
.cat-modal-close {
    background: none;
    border: none;
    cursor: pointer;
    color: #9ca3af;
    padding: 4px;
    border-radius: 6px;
    display: flex;
    transition: background 0.15s, color 0.15s;
}
.cat-modal-close:hover { background: #f3f4f6; color: #374151; }
.cat-modal-form { display: flex; flex-direction: column; gap: 16px; }
.cat-form-group { display: flex; flex-direction: column; gap: 6px; }
.cat-form-label { font-size: 0.875rem; font-weight: 500; color: #374151; }
.cat-form-input {
    border: 1px solid #d1d5db;
    border-radius: 8px;
    padding: 9px 13px;
    font-size: 0.9375rem;
    width: 100%;
    color: #111827;
    outline: none;
    transition: border-color 0.15s;
}
.cat-form-input:focus { border-color: #1D9E75; }
.cat-form-hint { font-size: 0.8125rem; color: #9ca3af; }
.cat-modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 4px;
    padding-top: 16px;
    border-top: 1px solid #f3f4f6;
}
.cat-btn-cancel {
    border: 1px solid #d1d5db;
    border-radius: 8px;
    padding: 9px 18px;
    font-size: 0.9375rem;
    background: #fff;
    cursor: pointer;
    color: #374151;
    transition: background 0.15s;
}
.cat-btn-cancel:hover { background: #f9fafb; }
.cat-btn-submit {
    border: none;
    border-radius: 8px;
    padding: 9px 20px;
    font-size: 0.9375rem;
    background: #1D9E75;
    color: #fff;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.15s;
}
.cat-btn-submit:hover { background: #0F6E56; }
 
/* ── Dropzone ── */
.cat-file-dropzone {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    border: 1.5px dashed #d1d5db;
    border-radius: 10px;
    padding: 24px 16px;
    cursor: pointer;
    text-align: center;
    transition: border-color 0.15s, background 0.15s;
    background: #fafafa;
}
.cat-file-dropzone:hover,
.cat-file-dropzone.cat-dragover {
    border-color: #1D9E75;
    background: #f0fdf8;
}
.cat-dropzone-text {
    font-size: 0.875rem;
    color: #374151;
}
.cat-dropzone-text strong { color: #1D9E75; font-weight: 600; }
.cat-dropzone-hint {
    font-size: 0.8125rem;
    color: #9ca3af;
}
.cat-file-preview {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 10px;
}
.cat-preview-thumb {
    position: relative;
    width: 64px;
    height: 64px;
    border-radius: 8px;
    overflow: hidden;
    border: 1px solid #e5e7eb;
}
.cat-preview-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.cat-preview-thumb button {
    position: absolute;
    top: 2px;
    right: 2px;
    background: rgba(0,0,0,0.5);
    border: none;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    color: #fff;
    font-size: 11px;
    line-height: 1;
    padding: 0;
    opacity: 0;
    transition: opacity 0.15s;
}
.cat-preview-thumb:hover button { opacity: 1; }
.cat-preview-count {
    font-size: 0.8125rem;
    color: #6b7280;
    align-self: center;
    margin-left: 4px;
}
</style>
 
<script>
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
 
// ── Dropzone / file preview ──
let selectedFiles = [];
 
function handleFileChange(input) {
    selectedFiles = Array.from(input.files);
    renderPreview();
}
 
function handleDrop(event) {
    event.preventDefault();
    document.getElementById('dropzone').classList.remove('cat-dragover');
    const dt = event.dataTransfer;
    if (dt && dt.files.length) {
        selectedFiles = Array.from(dt.files).filter(f => f.type.startsWith('image/'));
        updateFileInput();
        renderPreview();
    }
}
 
function removeFile(index) {
    selectedFiles.splice(index, 1);
    updateFileInput();
    renderPreview();
}
 
function updateFileInput() {
    const input = document.getElementById('file-input');
    const dt = new DataTransfer();
    selectedFiles.forEach(f => dt.items.add(f));
    input.files = dt.files;
}
 
function renderPreview() {
    const container = document.getElementById('file-preview');
    container.innerHTML = '';
    if (selectedFiles.length === 0) return;
 
    selectedFiles.forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const thumb = document.createElement('div');
            thumb.className = 'preview-thumb';
            thumb.innerHTML = `
                <img src="${e.target.result}" alt="${file.name}">
                <button type="button" onclick="removeFile(${i})" title="Quitar">✕</button>
            `;
            container.appendChild(thumb);
        };
        reader.readAsDataURL(file);
    });
 
    const count = document.createElement('span');
    count.className = 'preview-count';
    count.textContent = selectedFiles.length + ' archivo' + (selectedFiles.length !== 1 ? 's' : '') + ' seleccionado' + (selectedFiles.length !== 1 ? 's' : '');
    container.appendChild(count);
}
</script>
 
</x-layouts::app_administrador>