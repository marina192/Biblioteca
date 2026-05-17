<x-layouts::app_administrador>

<div class="usuarios-page">

    {{-- ── ENCABEZADO ── --}}
    <div class="page-header">
        <div class="page-header__text">
            <div class="edit-breadcrumb">
                <a href="{{ route('usuarios.index') }}" class="breadcrumb-link">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                        <line x1="19" y1="12" x2="5" y2="12"/>
                        <polyline points="12 19 5 12 12 5"/>
                    </svg>
                    Consejo de Usuarios
                </a>
                <span class="breadcrumb-sep">/</span>
                <span class="breadcrumb-current">Editar</span>
            </div>
            <h1 class="page-title">Editar Usuario</h1>
            <p class="page-subtitle">Modifica los datos de <strong>{{ $usuario->name }}</strong>.</p>
        </div>
    </div>

    @if ($usuario->is_super_admin)

        {{-- ── BLOQUE: SUPER ADMIN NO EDITABLE ── --}}
        <div class="table-card superadmin-notice">
            <div class="superadmin-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                </svg>
            </div>
            <h3 class="superadmin-title">Usuario protegido</h3>
            <p class="superadmin-desc">
                <strong>{{ $usuario->name }}</strong> es un Super Administrador del sistema y no puede ser modificado.
            </p>
            <a href="{{ route('usuarios.index') }}" class="btn-invite" style="display:inline-flex; margin-top:0.5rem;">
                Volver al listado
            </a>
        </div>

    @else

        {{-- ── FORMULARIO DE EDICIÓN ── --}}
        <div class="table-card edit-card">

            {{-- Avatar + info del usuario --}}
            <div class="edit-user-header">
                <div class="avatar avatar--{{ $usuario->hasRole('admin') ? 'admin' : 'lector' }} avatar--lg">
                    {{ strtoupper(substr($usuario->name, 0, 1)) }}
                </div>
                <div>
                    <p class="user-name">{{ $usuario->name }}</p>
                    <p class="user-email">{{ $usuario->email }}</p>
                    @foreach($usuario->getRoleNames() as $rol)
                        <span class="badge badge--{{ $rol }}" style="margin-top:0.35rem;">
                            {{ ucfirst($rol) }}
                        </span>
                    @endforeach
                </div>
            </div>

            <div class="edit-divider"></div>

            <form method="POST"
                    action="{{ route('usuarios.update', $usuario->id) }}"
                    enctype="multipart/form-data"
                    class="edit-form">
                @csrf
                @method('PUT')

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
                            value="{{ old('nombre', $usuario->name) }}"
                            required
                            placeholder="Nombre del usuario">
                        @error('nombre')
                            <span class="form-error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Correo electrónico</label>
                        <input class="form-input @error('email') is-error @enderror"
                            type="email" id="email" name="email"
                            value="{{ old('email', $usuario->email) }}"
                            required
                            placeholder="correo@dominio.com">
                        @error('email')
                            <span class="form-error-msg">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="rol">Rol del usuario</label>
                        <select class="form-input form-select @error('rol') is-error @enderror"
                                id="rol" name="rol" required>
                            <option value="lector"
                                {{ old('rol', $usuario->getRoleNames()->first()) == 'lector' ? 'selected' : '' }}>
                                Lector
                            </option>
                            <option value="admin"
                                {{ old('rol', $usuario->getRoleNames()->first()) == 'admin' ? 'selected' : '' }}>
                                Administrador
                            </option>
                        </select>
                        @error('rol')
                            <span class="form-error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">
                            Nueva contraseña
                            <span class="form-label-hint">(dejar vacío para no cambiar)</span>
                        </label>
                        <input class="form-input @error('password') is-error @enderror"
                            type="password" id="password" name="password"
                            placeholder="••••••••">
                        @error('password')
                            <span class="form-error-msg">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                @if(isset($password) || request()->has('password'))
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Confirmar nueva contraseña</label>
                    <input class="form-input"
                        type="password" id="password_confirmation"
                        name="password_confirmation"
                        placeholder="••••••••">
                </div>
                @endif

                <div class="edit-form-footer">
                    <a href="{{ route('usuarios.index') }}" class="btn-cancel">
                        Cancelar
                    </a>
                    <button type="submit" class="btn-submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Guardar cambios
                    </button>
                </div>

            </form>
        </div>

    @endif

</div>

</x-layouts::app_administrador>