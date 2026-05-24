<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        @vite(['resources/css/app.css',
                'resources/css/admin/dashboard.css',
                'resources/css/admin/usuarios.css',
                'resources/css/admin/categorias.css',
                'resources/css/admin/libros.css',
                'resources/css/admin/ejemplares.css',
                'resources/css/admin/prestamos.css',
                'resources/css/admin/reportes.css'])
        @livewireStyles
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600;700&family=Crimson+Text:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet">

        <style>
            :root {
                --arc-bg:              #060e1c;
                --arc-header-bg:       rgba(6, 14, 28, 0.92);
                --arc-sidebar-bg:      #080f1e;
                --arc-teal:            #3ecfaa;
                --arc-teal-border:     rgba(62, 207, 170, 0.22);
                --arc-teal-dim:        rgba(62, 207, 170, 0.08);
                --arc-text:            #c8dde8;
                --arc-muted:           #4a6a7a;
                --arc-border:          rgba(62, 207, 170, 0.08);
                --arc-moon:            #d8eef6;
            }

            body {
                font-family: 'Crimson Text', Georgia, serif;
            }

            /* ── Sidebar ── */
            [data-flux-sidebar] {
                background-color: var(--arc-sidebar-bg) !important;
                border-right: 1px solid var(--arc-border) !important;
            }

            [data-flux-sidebar]::before {
                content: '';
                display: block;
                height: 1px;
                background: linear-gradient(90deg, transparent, var(--arc-teal), transparent);
                opacity: 0.4;
            }

            [data-flux-sidebar-header] {
                border-bottom: 1px solid var(--arc-border) !important;
                padding: 1rem 1.1rem !important;
            }

            [data-flux-sidebar-item] {
                border-radius: 8px !important;
                font-family: 'Cinzel', serif !important;
                font-size: 0.65rem !important;
                letter-spacing: 0.14em !important;
                text-transform: uppercase !important;
                color: var(--arc-muted) !important;
                transition: background 0.15s, color 0.15s !important;
                margin: 2px 0 !important;
            }

            [data-flux-sidebar-item]:hover {
                background: var(--arc-teal-dim) !important;
                color: var(--arc-text) !important;
            }

            [data-flux-sidebar-item][aria-current="page"],
            [data-flux-sidebar-item][data-current] {
                background: var(--arc-teal-dim) !important;
                color: var(--arc-teal) !important;
                border: 1px solid var(--arc-teal-border) !important;
            }

            [data-flux-sidebar-item] svg {
                color: inherit !important;
                opacity: 0.8;
            }

            [data-flux-sidebar-group-heading] {
                font-family: 'Cinzel', serif !important;
                font-size: 0.6rem !important;
                letter-spacing: 0.18em !important;
                text-transform: uppercase !important;
                color: rgba(62,207,170,0.4) !important;
                padding: 0.5rem 0.6rem 0.25rem !important;
            }

            [data-flux-sidebar-nav] {
                padding: 0.75rem !important;
            }

            [data-flux-spacer] {
                border-top: 1px solid var(--arc-border) !important;
                margin: 0.5rem 0 !important;
            }

            /* ── Profile / Avatar ── */
            [data-flux-profile] {
                background: transparent !important;
                border: 1px solid transparent !important;
                border-radius: 999px !important;
                transition: background 0.2s, border-color 0.2s !important;
            }

            [data-flux-profile]:hover {
                background: var(--arc-teal-dim) !important;
                border-color: var(--arc-teal-border) !important;
            }

            [data-flux-avatar] {
                background: linear-gradient(135deg, rgba(62,207,170,0.22), rgba(62,207,170,0.1)) !important;
                color: var(--arc-teal) !important;
                border: 1px solid var(--arc-teal-border) !important;
                font-family: 'Cinzel', serif !important;
                font-size: 0.65rem !important;
                font-weight: 600 !important;
                letter-spacing: 0.05em !important;
            }

            [data-flux-heading] {
                color: var(--arc-text) !important;
                font-family: 'Crimson Text', serif !important;
                font-size: 0.85rem !important;
                font-weight: 600 !important;
            }

            [data-flux-text] {
                color: var(--arc-muted) !important;
                font-family: 'Crimson Text', serif !important;
                font-size: 0.75rem !important;
            }

            /* ── Header (aplica a ambos: escritorio y móvil) ── */
            [data-flux-header] {
                background: var(--arc-header-bg) !important;
                backdrop-filter: blur(20px) saturate(1.4) !important;
                -webkit-backdrop-filter: blur(20px) saturate(1.4) !important;
                border-bottom: 1px solid var(--arc-border) !important;
                min-height: 60px !important;
                position: relative;
            }

            [data-flux-header]::before {
                content: '';
                position: absolute;
                top: 0; left: 0; right: 0;
                height: 1px;
                background: linear-gradient(90deg,
                    transparent 0%,
                    rgba(62,207,170,0) 5%,
                    rgba(62,207,170,0.6) 35%,
                    rgba(62,207,170,0.9) 50%,
                    rgba(62,207,170,0.6) 65%,
                    rgba(62,207,170,0) 95%,
                    transparent 100%
                );
                pointer-events: none;
                z-index: 1;
            }

            /* ── Dropdown ── */
            [data-flux-menu] {
                background: #080f1e !important;
                border: 1px solid var(--arc-teal-border) !important;
                border-radius: 12px !important;
                box-shadow: 0 16px 48px rgba(0,0,0,0.6) !important;
                overflow: hidden;
            }

            [data-flux-menu]::before {
                content: '';
                display: block;
                height: 1px;
                background: linear-gradient(90deg, transparent, rgba(62,207,170,0.4), transparent);
            }

            [data-flux-menu-item] {
                font-family: 'Cinzel', serif !important;
                font-size: 0.65rem !important;
                letter-spacing: 0.12em !important;
                text-transform: uppercase !important;
                color: var(--arc-muted) !important;
                border-radius: 8px !important;
                transition: background 0.15s, color 0.15s !important;
            }

            [data-flux-menu-item]:hover {
                background: var(--arc-teal-dim) !important;
                color: var(--arc-teal) !important;
            }

            [data-flux-menu-separator] {
                border-color: var(--arc-border) !important;
            }

            /* ── Toast ── */
            [data-flux-toast] {
                background: #0a1628 !important;
                border: 1px solid var(--arc-teal-border) !important;
                color: var(--arc-text) !important;
                font-family: 'Crimson Text', serif !important;
                border-radius: 12px !important;
            }

            /* ── Main ── */
            main, [data-flux-main] {
            }

            /* ── Logo / brand ── */
            .arc-brand {
                font-family: 'Cinzel', serif !important;
                font-size: 1.05rem !important;
                font-weight: 600 !important;
                letter-spacing: 0.12em !important;
                color: var(--arc-moon) !important;
                transition: color 0.2s !important;
            }

            .arc-brand:hover {
                color: var(--arc-teal) !important;
            }

            /* ── Nav links escritorio ── */
            .arc-nav-link {
                font-family: 'Cinzel', serif !important;
                font-size: 0.75rem !important;
                font-weight: 400 !important;
                letter-spacing: 0.16em !important;
                text-transform: uppercase !important;
                transition: color 0.25s !important;
                /* Que el link ocupe toda la altura del header
                   para que el border-bottom quede al ras del borde inferior */
                align-self: stretch !important;
                display: flex !important;
                align-items: center !important;
                padding-bottom: 0 !important;
                margin-bottom: -1px !important; /* cubre el border-bottom del header */
            }

            /* PREVENT OVERLAP */
            [data-flux-header] nav {
                flex-wrap: nowrap !important;
            }

            [data-flux-header] > div {
                min-width: 0;
            }

            [data-flux-header] a {
                text-decoration: none !important;
            }

            .desktop-user-menu,
            [data-desktop-user-menu] {
                display: flex !important;
                align-items: center !important;
            }

            /* ── Sidebar fondo ── */
            [data-flux-sidebar] {
                background: linear-gradient(180deg, #060e1c 0%, #080f1e 60%, #060e1c 100%) !important;
                border-right: 1px solid rgba(62,207,170,0.12) !important;
            }

            /* Línea teal superior */
            [data-flux-sidebar]::before {
                content: '';
                display: block;
                height: 1px;
                background: linear-gradient(90deg, transparent, rgba(62,207,170,0.7), transparent);
                margin-bottom: 0.5rem;
            }

            /* ── Botón cerrar (X) ── */
            [data-flux-sidebar-toggle] {
                color: rgba(62,207,170,0.5) !important;
                transition: color 0.2s !important;
            }
            [data-flux-sidebar-toggle]:hover {
                color: #3ecfaa !important;
            }

            /* ── Items del nav ── */
            [data-flux-navlist-item] {
                font-family: 'Cinzel', serif !important;
                font-size: 0.7rem !important;
                letter-spacing: 0.18em !important;
                text-transform: uppercase !important;
                color: #4a6a7a !important;
                border-radius: 8px !important;
                padding: 0.65rem 0.85rem !important;
                margin: 2px 0 !important;
                transition: background 0.2s, color 0.2s !important;
                border: 1px solid transparent !important;
            }

            [data-flux-navlist-item]:hover {
                background: rgba(62,207,170,0.07) !important;
                color: #c8dde8 !important;
            }

            /* ── Item activo ── */
            [data-flux-navlist-item][aria-current="page"],
            [data-flux-navlist-item][data-current] {
                background: rgba(62,207,170,0.08) !important;
                color: #3ecfaa !important;
                border: 1px solid rgba(62,207,170,0.2) !important;
                box-shadow: inset 0 0 20px rgba(62,207,170,0.04) !important;
            }

            /* ── Nombre de la app en el header del sidebar ── */
            [data-flux-sidebar-header] {
                border-bottom: 1px solid rgba(62,207,170,0.08) !important;
                padding: 1.1rem 1rem !important;
                font-family: 'Cinzel', serif !important;
                font-size: 1rem !important;
                letter-spacing: 0.1em !important;
                color: #d8eef6 !important;
            }

            /* ── Espaciado del navlist ── */
            [data-flux-navlist] {
                padding: 0.75rem !important;
                gap: 2px !important;
            }
        </style>
    </head>
    <body id="main-body" class="min-h-screen bg-white text-gray-900 overflow-x-hidden">

        <!-- Navegación móvil -->
        <flux:sidebar
            sticky
            collapsible="mobile"
            class="lg:hidden bg-[#0d1f38] border-r border-zinc-700"
        >

            <flux:sidebar.toggle
                class="lg:hidden"
                icon="x-mark"
            />

            <flux:navlist>

                <flux:navlist.item
                    href="{{ route('admin.usuarios.index') }}"
                    wire:navigate
                    :current="request()->routeIs('admin.usuarios.*')"
                >
                    Usuarios
                </flux:navlist.item>

                <flux:navlist.item
                    href="{{ route('admin.categorias.index') }}"
                    wire:navigate
                    :current="request()->routeIs('admin.categorias.*')"
                >
                    Categorías
                </flux:navlist.item>

                <flux:navlist.item
                    href="{{ route('admin.libros.index') }}"
                    wire:navigate
                    :current="request()->routeIs('admin.libros.*')"
                >
                    Libros
                </flux:navlist.item>

                <flux:navlist.item
                    href="{{ route('admin.ejemplares.index') }}"
                    wire:navigate
                    :current="request()->routeIs('admin.ejemplares.*')"
                >
                    Ejemplares
                </flux:navlist.item>

                <flux:navlist.item
                    href="{{ route('admin.prestamos.index') }}"
                    wire:navigate
                    :current="request()->routeIs('admin.prestamos.*')"
                >
                    Préstamos
                </flux:navlist.item>

                <flux:navlist.item
                    href="{{ route('admin.reportes.index') }}"
                    wire:navigate
                    :current="request()->routeIs('admin.reportes.*')"
                >
                    Reportes
                </flux:navlist.item>

            </flux:navlist>

        </flux:sidebar>

        <!-- Navegación escritorio -->
        <flux:header
            class="hidden lg:flex items-center
                border-b border-zinc-700
                bg-[#0d1f38]
                px-8 py-3"
        >

            <!-- Izquierda -->
            <div class="flex flex-1 items-center">
                <a
                    href="{{ route('admin.dashboard') }}"
                    wire:navigate
                    class="arc-brand text-[1.05rem]
                        font-semibold
                        tracking-wide
                        text-[#d0e8e0]
                        whitespace-nowrap"
                >
                    Edda
                </a>
            </div>

            <!-- Centro -->
            <div class="flex justify-center">
                <nav style="display:flex; align-items:stretch; height:100%;">

                    <a
                        href="{{ route('admin.usuarios.index') }}"
                        wire:navigate
                        style="
                            margin-right:60px;
                            @if(request()->routeIs('admin.usuarios.*'))
                                border-bottom:3px solid #3ecfaa;
                                color:#3ecfaa;
                                box-shadow: 0 3px 12px rgba(62,207,170,0.35);
                            @else
                                border-bottom:3px solid transparent;
                                color:#6f8ca0;
                            @endif
                        "
                        class="arc-nav-link transition-all duration-300 hover:text-[#d0e8e0]"
                    >
                        Usuarios
                    </a>

                    <a
                        href="{{ route('admin.categorias.index') }}"
                        wire:navigate
                        style="
                            margin-right:60px;
                            @if(request()->routeIs('admin.categorias.*'))
                                border-bottom:3px solid #3ecfaa;
                                color:#3ecfaa;
                                box-shadow: 0 3px 12px rgba(62,207,170,0.35);
                            @else
                                border-bottom:3px solid transparent;
                                color:#6f8ca0;
                            @endif
                        "
                        class="arc-nav-link transition-all duration-300 hover:text-[#d0e8e0]"
                    >
                        Categorías
                    </a>

                    <a
                        href="{{ route('admin.libros.index') }}"
                        wire:navigate
                        style="
                            margin-right:60px;
                            @if(request()->routeIs('admin.libros.*'))
                                border-bottom:3px solid #3ecfaa;
                                color:#3ecfaa;
                                box-shadow: 0 3px 12px rgba(62,207,170,0.35);
                            @else
                                border-bottom:3px solid transparent;
                                color:#6f8ca0;
                            @endif
                        "
                        class="arc-nav-link transition-all duration-300 hover:text-[#d0e8e0]"
                    >
                        Libros
                    </a>

                    <a
                        href="{{ route('admin.ejemplares.index') }}"
                        wire:navigate
                        style="
                            margin-right:60px;
                            @if(request()->routeIs('admin.ejemplares.*'))
                                border-bottom:3px solid #3ecfaa;
                                color:#3ecfaa;
                                box-shadow: 0 3px 12px rgba(62,207,170,0.35);
                            @else
                                border-bottom:3px solid transparent;
                                color:#6f8ca0;
                            @endif
                        "
                        class="arc-nav-link transition-all duration-300 hover:text-[#d0e8e0]"
                    >
                        Ejemplares
                    </a>

                    <a
                        href="{{ route('admin.prestamos.index') }}"
                        wire:navigate
                        style="
                            margin-right:60px;
                            @if(request()->routeIs('admin.prestamos.*'))
                                border-bottom:3px solid #3ecfaa;
                                color:#3ecfaa;
                                box-shadow: 0 3px 12px rgba(62,207,170,0.35);
                            @else
                                border-bottom:3px solid transparent;
                                color:#6f8ca0;
                            @endif
                        "
                        class="arc-nav-link transition-all duration-300 hover:text-[#d0e8e0]"
                    >
                        Préstamos
                    </a>

                    <a
                        href="{{ route('admin.reportes.index') }}"
                        wire:navigate
                        style="
                            @if(request()->routeIs('admin.reportes.*'))
                                border-bottom:3px solid #3ecfaa;
                                color:#3ecfaa;
                                box-shadow: 0 3px 12px rgba(62,207,170,0.35);
                            @else
                                border-bottom:3px solid transparent;
                                color:#6f8ca0;
                            @endif
                        "
                        class="arc-nav-link transition-all duration-300 hover:text-[#d0e8e0]"
                    >
                        Reportes
                    </a>

                </nav>
            </div>

            <!-- Derecha -->
            <div class="flex flex-1 justify-end items-center">
                <x-desktop-user-menu :name="auth()->user()->name" />
            </div>

        </flux:header>

        <!-- Menú de usuario -->
        <flux:header class="flex lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @persist('toast')
            <flux:toast.group>
                <flux:toast />
            </flux:toast.group>
        @endpersist

        @fluxScripts

        
        <script>
            function updateBodyBg() {
                const body = document.getElementById('main-body');
                const isSettings = window.location.pathname.startsWith('/settings') 
                                || window.location.pathname.startsWith('/user/confirm-password');

                if (isSettings) {
                    body.style.backgroundColor = '#060e1c';
                    body.style.color = '#f3f4f6';

                    document.querySelectorAll('label').forEach(el => {
                        el.style.color = '#c8dde8';
                    });
                } else {
                    body.style.backgroundColor = '#ffffff';
                    body.style.color = '#111827';

                    document.querySelectorAll('label').forEach(el => {
                        el.style.color = '';
                    });
                }
}

            updateBodyBg();
            document.addEventListener('livewire:navigated', updateBodyBg);
        </script>

    </body>
</html>