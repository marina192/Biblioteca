<x-layouts::app_administrador>

{{-- Encabezado --}}
<div class="cedit-page-header">
    <div class="cedit-page-header-left">
        <a href="{{ route('admin.categorias.index') }}" class="cedit-btn-back">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                <path d="M19 12H5M5 12l7 7M5 12l7-7"/>
            </svg>
            Volver
        </a>
        <div>
            <h1 class="cedit-page-title">Editar categoría</h1>
            <p class="cedit-page-subtitle">{{ $categoria->nombre }}</p>
        </div>
    </div>
</div>

<form
    method="POST"
    action="{{ route('admin.categorias.update', $categoria->id) }}"
    enctype="multipart/form-data"
    class="cedit-edit-layout"
>
    @csrf
    @method('PUT')

    {{-- Columna principal --}}
    <div class="cedit-edit-main">

        {{-- Datos generales --}}
        <div class="cedit-card">
            <div class="cedit-card-header">
                <h2 class="cedit-card-title">Datos generales</h2>
            </div>
            <div class="cedit-card-body">

                <div class="cedit-form-group">
                    <label class="cedit-form-label" for="nombre">Nombre</label>
                    <input
                        type="text"
                        id="nombre"
                        name="nombre"
                        class="cedit-form-input {{ $errors->has('nombre') ? 'cedit-input-error' : '' }}"
                        value="{{ old('nombre', $categoria->nombre) }}"
                        placeholder="Nombre de la categoría"
                        required
                    >
                    @error('nombre')
                        <span class="cedit-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="cedit-form-group">
                    <label class="cedit-form-label" for="descripcion">Descripción</label>
                    <textarea
                        id="descripcion"
                        name="descripcion"
                        class="cedit-form-input cedit-form-textarea {{ $errors->has('descripcion') ? 'cedit-input-error' : '' }}"
                        placeholder="Breve descripción de la categoría"
                        required
                    >{{ old('descripcion', $categoria->descripcion) }}</textarea>
                    @error('descripcion')
                        <span class="cedit-form-error">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </div>

        {{-- Imágenes actuales --}}
        <div class="cedit-card">
            <div class="cedit-card-header">
                <h2 class="cedit-card-title">Imágenes actuales</h2>
                <span class="cedit-card-badge">
                    {{ count($categoria->imagenes ?? []) }}
                    imagen{{ count($categoria->imagenes ?? []) !== 1 ? 'es' : '' }}
                </span>
            </div>
            <div class="cedit-card-body">

                @php $imgs = array_values(array_filter($categoria->imagenes ?? [])); @endphp

                @if (count($imgs) > 0)
                    <div class="cedit-current-images-grid" id="current-images-grid">
                        @foreach ($imgs as $i => $imagen)
                            <div class="cedit-current-img-wrap" id="cedit-img-wrap-{{ $i }}">
                                <img
                                    src="{{ asset('storage/' . $imagen) }}"
                                    alt="Imagen {{ $i + 1 }}"
                                >
                                <input
                                    type="hidden"
                                    name="imagenes_existentes[]"
                                    value="{{ $imagen }}"
                                    id="cedit-img-input-{{ $i }}"
                                >
                                <button
                                    type="button"
                                    class="cedit-img-remove-btn"
                                    onclick="removeExistingImage({{ $i }})"
                                    title="Quitar imagen"
                                >
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                        <path d="M18 6L6 18M6 6l12 12"/>
                                    </svg>
                                </button>
                                <div class="cedit-img-overlay">Imagen {{ $i + 1 }}</div>
                            </div>
                        @endforeach
                    </div>
                    <p class="cedit-images-hint">Haz clic en ✕ para quitar una imagen existente.</p>
                @else
                    <div class="cedit-no-images">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1" style="opacity:0.3">
                            <rect x="3" y="5" width="18" height="14" rx="2"/>
                            <path d="M3 15l5-5c.928-.893 2.072-.893 3 0l5 5"/>
                            <path d="M14 14l1-1c.928-.893 2.072-.893 3 0l3 3"/>
                        </svg>
                        <span>Esta categoría no tiene imágenes aún.</span>
                    </div>
                @endif

            </div>
        </div>

        {{-- Agregar imágenes --}}
        <div class="cedit-card">
            <div class="cedit-card-header">
                <h2 class="cedit-card-title">Agregar imágenes</h2>
            </div>
            <div class="cedit-card-body">

                <input
                    type="file"
                    name="imagenes[]"
                    id="cedit-file-input"
                    multiple
                    accept="image/*"
                    style="display:none"
                    onchange="ceditHandleFileChange(this)"
                >

                <div
                    class="cedit-file-dropzone"
                    id="cedit-dropzone"
                    onclick="document.getElementById('cedit-file-input').click()"
                    ondragover="event.preventDefault(); this.classList.add('cedit-dragover')"
                    ondragleave="this.classList.remove('cedit-dragover')"
                    ondrop="ceditHandleDrop(event)"
                >
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.25" stroke-linecap="round"
                            style="color:#9ca3af; flex-shrink:0">
                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                        <path d="M3 15l5-5c.928-.893 2.072-.893 3 0l5 5"/>
                        <path d="M14 14l1-1c.928-.893 2.072-.893 3 0l3 3"/>
                    </svg>
                    <span class="cedit-dropzone-text"><strong>Haz clic para seleccionar</strong> o arrastra aquí</span>
                    <span class="cedit-dropzone-hint">PNG, JPG, WEBP — varias a la vez</span>
                </div>

                <div class="cedit-file-preview" id="cedit-file-preview"></div>

            </div>
        </div>

    </div>

    {{-- Barra de acciones --}}
    <div class="cedit-action-bar">
        <a href="{{ route('admin.categorias.index') }}" class="cedit-btn-cancel">Cancelar</a>
        <button type="submit" class="cedit-btn-submit">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <path d="M5 12l5 5L20 7"/>
            </svg>
            Guardar cambios
        </button>
    </div>

</form>

<script>
let ceditSelectedFiles = [];

function ceditHandleFileChange(input) {
    ceditSelectedFiles = Array.from(input.files);
    ceditRenderPreview();
}

function ceditHandleDrop(event) {
    event.preventDefault();
    document.getElementById('cedit-dropzone').classList.remove('cedit-dragover');
    const dt = event.dataTransfer;
    if (dt && dt.files.length) {
        ceditSelectedFiles = Array.from(dt.files).filter(f => f.type.startsWith('image/'));
        ceditUpdateFileInput();
        ceditRenderPreview();
    }
}

function ceditRemoveFile(index) {
    ceditSelectedFiles.splice(index, 1);
    ceditUpdateFileInput();
    ceditRenderPreview();
}

function ceditUpdateFileInput() {
    const input = document.getElementById('cedit-file-input');
    const dt = new DataTransfer();
    ceditSelectedFiles.forEach(f => dt.items.add(f));
    input.files = dt.files;
}

function ceditRenderPreview() {
    const container = document.getElementById('cedit-file-preview');
    container.innerHTML = '';
    if (ceditSelectedFiles.length === 0) return;

    ceditSelectedFiles.forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            const thumb = document.createElement('div');
            thumb.className = 'cedit-preview-thumb';
            thumb.innerHTML = `
                <img src="${e.target.result}" alt="${file.name}">
                <button type="button" onclick="ceditRemoveFile(${i})" title="Quitar">✕</button>
            `;
            container.insertBefore(thumb, container.lastElementChild || null);
        };
        reader.readAsDataURL(file);
    });

    const count = document.createElement('span');
    count.className = 'cedit-preview-count';
    const n = ceditSelectedFiles.length;
    count.textContent = n + ' archivo' + (n !== 1 ? 's' : '') + ' nuevo' + (n !== 1 ? 's' : '');
    container.appendChild(count);
}

function removeExistingImage(index) {
    const wrap = document.getElementById('cedit-img-wrap-' + index);
    const input = document.getElementById('cedit-img-input-' + index);
    if (wrap) wrap.classList.add('cedit-removed');
    if (input) input.disabled = true;
}
</script>

</x-layouts::app_administrador>