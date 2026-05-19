<x-layouts::app_administrador>

{{-- Encabezado --}}
<div class="ejemedit-page-header">
    <div class="ejemedit-page-header-left">
        <a href="{{ route('ejemplares.index') }}" class="ejemedit-btn-back">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                <path d="M19 12H5M5 12l7 7M5 12l7-7"/>
            </svg>
            Volver
        </a>
        <div>
            <h1 class="ejemedit-page-title">Editar ejemplar</h1>
            <p class="ejemedit-page-subtitle">{{ $ejemplar->libro->titulo }}</p>
        </div>
    </div>
</div>

<form
    method="POST"
    action="{{ route('ejemplares.update', $ejemplar->id) }}"
    enctype="multipart/form-data"
    class="ejemedit-edit-layout"
>
    @csrf
    @method('PUT')

    {{-- Columna principal --}}
    <div class="ejemedit-edit-main">

        {{-- Datos generales --}}
        <div class="ejemedit-card">
            <div class="ejemedit-card-header">
                <h2 class="ejemedit-card-title">Datos generales</h2>
            </div>
            <div class="ejemedit-card-body">

                @if($ejemplar->estado != 'prestado')
                    <div class="ejemedit-form-group">
                        <label class="ejemedit-form-label" for="estado">Estado</label>
                        <select
                            id="estado"
                            name="estado"
                            class="ejemedit-form-input {{ $errors->has('estado') ? 'ejemedit-input-error' : '' }}"
                            required
                        >
                            <option value="disponible" {{ old('estado', $ejemplar->estado) == 'disponible' ? 'selected' : '' }}>Disponible</option>
                            <option value="dañado" {{ old('estado', $ejemplar->estado) == 'dañado' ? 'selected' : '' }}>Dañado</option>
                        </select>
                        @error('estado')
                            <span class="ejemedit-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                @endif

                <div class="ejemedit-form-group">
                    <label class="ejemedit-form-label" for="ubicacion">Ubicación</label>
                    <input
                        type="text"
                        id="ubicacion"
                        name="ubicacion"
                        class="ejemedit-form-input {{ $errors->has('ubicacion') ? 'ejemedit-input-error' : '' }}"
                        value="{{ old('ubicacion', $ejemplar->ubicacion) }}"
                        placeholder="Ubicación del ejemplar en la biblioteca"
                        required
                    >
                    @error('ubicacion')
                        <span class="ejemedit-form-error">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </div>

    </div>

    {{-- Barra de acciones --}}
    <div class="ejemedit-action-bar">
        <a href="{{ route('ejemplares.index') }}" class="ejemedit-btn-cancel">Cancelar</a>
        <button type="submit" class="ejemedit-btn-submit">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round">
                <path d="M5 12l5 5L20 7"/>
            </svg>
            Guardar cambios
        </button>
    </div>

</form>

</x-layouts::app_administrador>