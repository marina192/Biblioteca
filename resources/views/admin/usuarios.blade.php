<x-layouts::app_administrador>

<div class="usuarios-page">

    {{-- ── ENCABEZADO ── --}}
    <div class="page-header">
        <div class="page-header__text">
            <h1 class="page-title">Consejo de Usuarios</h1>
            <p class="page-subtitle">Gestiona los guardianes del sistema y sus permisos de acceso.</p>
        </div>

        <button
            class="btn-invite"
            onclick="document.getElementById('modal-nuevo-usuario').classList.add('is-open')"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <line x1="19" y1="8" x2="19" y2="14"/>
                <line x1="16" y1="11" x2="22" y2="11"/>
            </svg>
            Invitar Nuevo Usuario
        </button>
    </div>

    {{-- ── BARRA DE BÚSQUEDA Y FILTROS ── --}}
    <form
        method="GET"
        action="{{ route('admin.usuarios.index') }}"
        class="toolbar"
    >
        <!-- Barra de búsqueda -->
        <div class="search-wrapper">
            <svg class="search-icon"
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
            >
                <circle cx="11" cy="11" r="8"/>
                <line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input
                class="search-input"
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Buscar por nombre o correo..."
            >
        </div>

        <div class="toolbar__actions">
            <!-- Filtro por rol -->
            <select
                name="rol"
                class="role-select"
            >
                <option value="">Todos</option>
                <option
                    value="admin"
                    @selected(request('rol') == 'admin')
                >
                    Admin
                </option>
                <option
                    value="lector"
                    @selected(request('rol') == 'lector')
                >
                    Lector
                </option>
            </select>

            <!-- Ordenar por nombre -->
            <select
                name="orden"
                class="role-select"
            >
                <option value="">Ordenar</option>
                <option
                    value="nombre_asc"
                    @selected(request('orden') == 'nombre_asc')
                >
                    Nombre A-Z
                </option>
                <option
                    value="nombre_desc"
                    @selected(request('orden') == 'nombre_desc')
                >
                    Nombre Z-A
                </option>
            </select>

            <button
                type="submit"
                class="btn-tool"
                >
                Filtrar
            </button>
        </div>
    </form>

    {{-- ── TABLA DE USUARIOS ── --}}
    <div class="table-card">
        <table class="users-table">
            <thead>
                <tr>
                    <th class="col-avatar">Avatar</th>
                    <th class="col-name">Nombre</th>
                    <th class="col-rank">Rol</th>
                    <th class="col-actions">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($usuarios as $usuario)
                    @php
                        $isAdmin       = $usuario->hasRole('admin');
                        $isSuperAdmin  = $usuario->is_super_admin ?? false;
                        $roles         = $usuario->getRoleNames();
                        $initials      = strtoupper(substr($usuario->name, 0, 1));
                    @endphp

                    <tr class="user-row">

                        {{-- Avatar --}}
                        <td class="col-avatar">
                            <div class="avatar avatar--{{ $isAdmin ? 'admin' : 'lector' }}">
                                {{ $initials }}
                            </div>
                        </td>

                        {{-- Nombre + Email --}}
                        <td class="col-name">
                            <span class="user-name">{{ $usuario->name }}</span>
                            <span class="user-email">{{ $usuario->email }}</span>
                        </td>

                        {{-- Rol / Badge --}}
                        <td class="col-rank">
                            @foreach($roles as $rol)
                                <span class="badge badge--{{ $rol }}">
                                    {{ ucfirst($rol) }}
                                </span>
                            @endforeach
                        </td>

                        {{-- Acciones --}}
                        <td class="col-actions">
                            @if(auth()->user()->is_super_admin)
                                @if (!$isSuperAdmin)
                                    @if ($isAdmin)
                                        <div class="actions-group">
                                            <a href="{{ route('admin.usuarios.edit', $usuario->id) }}"
                                                class="btn-action btn-action--edit"
                                                title="Modificar">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                                </svg>
                                                Editar
                                            </a>

                                            <form
                                                action="{{ route('admin.usuarios.destroy', $usuario->id) }}"
                                                method="POST"
                                                class="delete-form"
                                                onsubmit="return confirm('¿Eliminar al usuario {{ $usuario->name }}?')"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-action--delete" title="Eliminar">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <polyline points="3 6 5 6 21 6"/>
                                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                                        <path d="M10 11v6"/><path d="M14 11v6"/>
                                                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                                    </svg>
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="actions-group">
                                            {{-- Cambio rápido de rol (solo lectores) --}}
                                            @if(!$isAdmin)
                                                <form action="{{ route('admin.usuarios.update', $usuario->id) }}"
                                                        method="POST" class="role-form">
                                                    @csrf
                                                    @method('PUT')
                                                    <select name="rol"
                                                            class="role-select"
                                                            onchange="this.form.submit()"
                                                            title="Cambiar rol">
                                                        <option value="lector" {{ $usuario->hasRole('lector') ? 'selected' : '' }}>Lector</option>
                                                        <option value="admin"  {{ $usuario->hasRole('admin')  ? 'selected' : '' }}>Admin</option>
                                                    </select>
                                                </form>
                                                @if($usuario->prestamos_blocked)
                                                    <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST" class="delete-form">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="desbloquear" value="1">
                                                        <button type="submit" class="btn-action btn-action--unblock" title="Desbloquear préstamos">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M8 11V7a4 4 0 0 1 8 0"/>
                                                                <rect x="3" y="11" width="18" height="11" rx="2"/>
                                                                <circle cx="12" cy="16" r="1" fill="currentColor"/>
                                                            </svg>
                                                            Desbloquear
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        </div>
                                    @endif
                                @else
                                    <span class="super-admin-badge">Super Admin</span>
                                @endif
                            @else
                                @if ($isSuperAdmin)
                                    <span class="super-admin-badge">Super Admin</span>
                                @endif
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ── PIE DE TABLA / PAGINACIÓN ── --}}
        <div class="table-footer">
            <span class="table-count">
                Mostrando {{ $usuarios->count() }} usuarios en total
            </span>
        </div>
    </div>

</div>

{{-- ═══════════════════════════════════════════
    MODAL: Crear Nuevo Usuario
    ═══════════════════════════════════════════ --}}
<div id="modal-nuevo-usuario" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('is-open')">
    <div class="modal-card">

        <div class="modal-header">
            <h2 class="modal-title">Invitar Nuevo Usuario</h2>
            <button class="modal-close" onclick="document.getElementById('modal-nuevo-usuario').classList.remove('is-open')">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.usuarios.store') }}" enctype="multipart/form-data" class="modal-form">
            @csrf

            @if ($errors->any())
                <div class="form-errors">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="nombre">Nombre completo</label>
                    <input class="form-input @error('nombre') is-error @enderror"
                            type="text" id="nombre" name="nombre"
                            value="{{ old('nombre') }}" required
                            placeholder="Ej. Ana García">
                    @error('nombre')
                        <span class="form-error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Correo electrónico</label>
                    <input class="form-input @error('email') is-error @enderror"
                            type="email" id="email" name="email"
                            value="{{ old('email') }}" required
                            placeholder="usuario@dominio.com">
                    @error('email')
                        <span class="form-error-msg">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="password">Contraseña</label>
                    <input class="form-input @error('password') is-error @enderror"
                            type="password" id="password" name="password" required
                            placeholder="Mínimo 8 caracteres">
                    @error('password')
                        <span class="form-error-msg">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirmar Contraseña</label>
                    <input class="form-input"
                            type="password" id="password_confirmation"
                            name="password_confirmation" required
                            placeholder="Repite la contraseña">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="rol">Rol del usuario</label>
                <select class="form-input form-select" id="rol" name="rol" required>
                    <option value="">— Selecciona un rol —</option>
                    <option value="lector" {{ old('rol') == 'lector' ? 'selected' : '' }}>Lector</option>
                    <option value="admin"  {{ old('rol') == 'admin'  ? 'selected' : '' }}>Administrador</option>
                </select>
            </div>

            <div class="modal-footer">
                <button type="button"
                        class="btn-cancel"
                        onclick="document.getElementById('modal-nuevo-usuario').classList.remove('is-open')">
                    Cancelar
                </button>
                <button type="submit" class="btn-submit">Crear Usuario</button>
            </div>
        </form>

    </div>
</div>

{{-- Abrir modal automáticamente si hubo errores de validación --}}
@if ($errors->any())
<script>
    document.getElementById('modal-nuevo-usuario').classList.add('is-open');
</script>
@endif

</x-layouts::app_administrador>