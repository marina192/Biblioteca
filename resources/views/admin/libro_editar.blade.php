<x-layouts::app_administrador>

{{-- Encabezado --}}
<div class="ledit-page-header">
    <div class="ledit-page-header-left">
        <a href="{{ route('admin.libros.index') }}" class="ledit-btn-back">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                <path d="M19 12H5M5 12l7 7M5 12l7-7"/>
            </svg>
            Volver
        </a>
        <div>
            <h1 class="ledit-page-title">Editar libro</h1>
            <p class="ledit-page-subtitle">{{ $libro->titulo }}</p>
        </div>
    </div>
</div>

<form
    method="POST"
    action="{{ route('admin.libros.update', $libro->id) }}"
    enctype="multipart/form-data"
    class="ledit-layout"
>
    @csrf
    @method('PUT')

    <div class="ledit-main">

        {{-- Datos generales --}}
        <div class="ledit-card">
            <div class="ledit-card-header">
                <h2 class="ledit-card-title">Datos generales</h2>
            </div>
            <div class="ledit-card-body">

                <div class="ledit-grid-2">

                    <div class="ledit-form-group">
                        <label class="ledit-form-label" for="titulo">Título</label>
                        <input
                            type="text"
                            id="titulo"
                            name="titulo"
                            class="ledit-form-input {{ $errors->has('titulo') ? 'ledit-input-error' : '' }}"
                            value="{{ old('titulo', $libro->titulo) }}"
                            placeholder="Título del libro"
                            required
                        >
                        @error('titulo')<span class="ledit-form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="ledit-form-group">
                        <label class="ledit-form-label" for="autor">Autor</label>
                        <input
                            type="text"
                            id="autor"
                            name="autor"
                            class="ledit-form-input {{ $errors->has('autor') ? 'ledit-input-error' : '' }}"
                            value="{{ old('autor', $libro->autor) }}"
                            placeholder="Nombre del autor"
                            required
                        >
                        @error('autor')<span class="ledit-form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="ledit-form-group">
                        <label class="ledit-form-label" for="editorial">Editorial</label>
                        <input
                            type="text"
                            id="editorial"
                            name="editorial"
                            class="ledit-form-input {{ $errors->has('editorial') ? 'ledit-input-error' : '' }}"
                            value="{{ old('editorial', $libro->editorial) }}"
                            placeholder="Editorial"
                            required
                        >
                        @error('editorial')<span class="ledit-form-error">{{ $message }}</span>@enderror
                    </div>

                    <div class="ledit-form-group">
                        <label class="ledit-form-label" for="fecha_publicacion">Fecha de publicación</label>
                        <input
                            type="date"
                            id="fecha_publicacion"
                            name="fecha_publicacion"
                            class="ledit-form-input {{ $errors->has('fecha_publicacion') ? 'ledit-input-error' : '' }}"
                            value="{{ old('fecha_publicacion', $libro->fecha_publicacion?->format('Y-m-d')) }}"
                            required
                        >
                        @error('fecha_publicacion')<span class="ledit-form-error">{{ $message }}</span>@enderror
                    </div>

                </div>

                <div class="ledit-form-group-sinopsis">
                    <label class="ledit-form-label" for="sinopsis">Sinopsis</label>
                    <textarea id="sinopsis"
                        name="sinopsis"
                        class="ledit-form-input {{ $errors->has('sinopsis') ? 'ledit-input-error' : '' }}"
                        placeholder="Sinopsis"
                        required>{{ old('sinopsis', $libro->sinopsis) }}</textarea>
                    @error('sinopsis')
                        <span class="ledit-form-error">{{ $message }}</span>
                    @enderror
                </div>
                    
            </div>
        </div>

        {{-- Categorías --}}
        <div class="ledit-card">
            <div class="ledit-card-header">
                <h2 class="ledit-card-title">Categorías</h2>
                <span class="ledit-card-badge">
                    {{ $libro->categorias->count() }} seleccionada{{ $libro->categorias->count() !== 1 ? 's' : '' }}
                </span>
            </div>
            <div class="ledit-card-body">
                <div class="ledit-checkboxes-grid">
                    @foreach ($categorias as $cat)
                        <label class="ledit-checkbox-item {{ $libro->categorias->contains($cat) ? 'ledit-checked' : '' }}"
                                id="label-cat-{{ $cat->id }}">
                            <input
                                type="checkbox"
                                name="categorias[]"
                                value="{{ $cat->id }}"
                                {{ $libro->categorias->contains($cat) ? 'checked' : '' }}
                                onchange="toggleCatLabel(this)"
                            >
                            <span>{{ $cat->nombre }}</span>
                        </label>
                    @endforeach
                </div>
                @if ($categorias->isEmpty())
                    <p class="ledit-empty-hint">No hay categorías disponibles.</p>
                @endif
            </div>
        </div>

        {{-- Imágenes actuales --}}
        <div class="ledit-card">
            <div class="ledit-card-header">
                <h2 class="ledit-card-title">Imágenes actuales</h2>
                <span class="ledit-card-badge">
                    {{ count($libro->imagenes ?? []) }} imagen{{ count($libro->imagenes ?? []) !== 1 ? 'es' : '' }}
                </span>
            </div>
            <div class="ledit-card-body">

                @php $imgs = array_values(array_filter($libro->imagenes ?? [])); @endphp

                @if (count($imgs) > 0)
                    <div class="ledit-images-grid">
                        @foreach ($imgs as $i => $imagen)
                            <div class="ledit-img-wrap" id="ledit-img-wrap-{{ $i }}">
                                <img src="{{ asset('storage/' . $imagen) }}" alt="Imagen {{ $i + 1 }}">
                                <input type="hidden" name="imagenes_existentes[]"
                                        value="{{ $imagen }}" id="ledit-img-input-{{ $i }}">
                                <button
                                    type="button"
                                    class="ledit-img-remove-btn"
                                    onclick="leditRemoveExisting({{ $i }})"
                                    title="Quitar imagen"
                                >
                                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                                        <path d="M18 6L6 18M6 6l12 12"/>
                                    </svg>
                                </button>
                                <div class="ledit-img-overlay">Imagen {{ $i + 1 }}</div>
                            </div>
                        @endforeach
                    </div>
                    <p class="ledit-images-hint">Haz clic en ✕ para quitar una imagen existente.</p>
                @else
                    <div class="ledit-no-images">
                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="1" style="opacity:0.3">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                        </svg>
                        <span>Este libro no tiene imágenes aún.</span>
                    </div>
                @endif

            </div>
        </div>

        {{-- Agregar imágenes --}}
        <div class="ledit-card">
            <div class="ledit-card-header">
                <h2 class="ledit-card-title">Agregar imágenes</h2>
            </div>
            <div class="ledit-card-body">

                <input
                    type="file"
                    name="imagenes[]"
                    id="ledit-file-input"
                    multiple
                    accept="image/*"
                    style="display:none"
                    onchange="leditHandleFileChange(this)"
                >

                <div
                    class="ledit-dropzone"
                    id="ledit-dropzone"
                    onclick="document.getElementById('ledit-file-input').click()"
                    ondragover="event.preventDefault(); this.classList.add('ledit-dragover')"
                    ondragleave="this.classList.remove('ledit-dragover')"
                    ondrop="leditHandleDrop(event)"
                >
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1.25" style="color:#9ca3af">
                        <rect x="3" y="5" width="18" height="14" rx="2"/>
                        <path d="M3 15l5-5c.928-.893 2.072-.893 3 0l5 5"/>
                        <path d="M14 14l1-1c.928-.893 2.072-.893 3 0l3 3"/>
                    </svg>
                    <span class="ledit-dropzone-text">
                        <strong>Haz clic para seleccionar</strong> o arrastra aquí
                    </span>
                    <span class="ledit-dropzone-hint">PNG, JPG, WEBP — varias a la vez</span>
                </div>

                <div class="ledit-file-preview" id="ledit-file-preview"></div>

            </div>
        </div>

    </div>

    {{-- Barra de acciones --}}
    <div class="ledit-action-bar">
        <a href="{{ route('admin.libros.index') }}" class="ledit-btn-cancel">Cancelar</a>
        <button type="submit" class="ledit-btn-submit">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <path d="M5 12l5 5L20 7"/>
            </svg>
            Guardar cambios
        </button>
    </div>

</form>

<script>
// Checkbox toggle visual
function toggleCatLabel(input) {
    const label = input.closest('.ledit-checkbox-item');
    if (label) label.classList.toggle('ledit-checked', input.checked);
}

// Quitar imagen existente
function leditRemoveExisting(index) {
    const wrap = document.getElementById('ledit-img-wrap-' + index);
    const input = document.getElementById('ledit-img-input-' + index);
    if (wrap) wrap.classList.add('ledit-removed');
    if (input) input.disabled = true;
}

// Dropzone / preview
let leditSelectedFiles = [];

function leditHandleFileChange(input) {
    leditSelectedFiles = Array.from(input.files);
    leditRenderPreview();
}

function leditHandleDrop(event) {
    event.preventDefault();
    document.getElementById('ledit-dropzone').classList.remove('ledit-dragover');
    const files = Array.from(event.dataTransfer.files).filter(f => f.type.startsWith('image/'));
    if (!files.length) return;
    leditSelectedFiles = files;
    const dt = new DataTransfer();
    files.forEach(f => dt.items.add(f));
    document.getElementById('ledit-file-input').files = dt.files;
    leditRenderPreview();
}

function leditRemoveFile(index) {
    leditSelectedFiles.splice(index, 1);
    const dt = new DataTransfer();
    leditSelectedFiles.forEach(f => dt.items.add(f));
    document.getElementById('ledit-file-input').files = dt.files;
    leditRenderPreview();
}

function leditRenderPreview() {
    const container = document.getElementById('ledit-file-preview');
    container.innerHTML = '';
    if (!leditSelectedFiles.length) return;

    leditSelectedFiles.forEach((file, i) => {
        const reader = new FileReader();
        reader.onload = e => {
            const thumb = document.createElement('div');
            thumb.className = 'ledit-preview-thumb';
            thumb.innerHTML = `
                <img src="${e.target.result}" alt="${file.name}">
                <button type="button" onclick="leditRemoveFile(${i})" title="Quitar">✕</button>
            `;
            container.appendChild(thumb);
        };
        reader.readAsDataURL(file);
    });

    const count = document.createElement('span');
    count.className = 'ledit-preview-count';
    count.textContent = leditSelectedFiles.length + ' archivo' +
        (leditSelectedFiles.length !== 1 ? 's' : '') + ' nuevo' +
        (leditSelectedFiles.length !== 1 ? 's' : '');
    container.appendChild(count);
}
</script>

</x-layouts::app_administrador>