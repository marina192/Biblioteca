<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ __('Welcome') }} - {{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            /* ─── CSS Variables ─────────────────────────────────────────── */
            :root {
                --forest-deep:    #050d12;
                --forest-dark:    #071520;
                --forest-mid:     #0a1e2e;
                --forest-panel:   rgba(8, 22, 36, 0.72);
                --moon-glow:      #c8e8f8;
                --teal-primary:   #00c9c8;
                --teal-soft:      rgba(0, 201, 200, 0.15);
                --teal-border:    rgba(0, 201, 200, 0.35);
                --violet-accent:  #7c3aed;
                --violet-soft:    rgba(124, 58, 237, 0.25);
                --text-primary:   #d8eef8;
                --text-muted:     #7aaec8;
                --radius-card:    18px;
                --transition:     0.28s cubic-bezier(0.4, 0, 0.2, 1);
            }

            /* ─── Reset & Base ─────────────────────────────────────────── */
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

            html {
                height: 100%;
                scroll-behavior: smooth;
                overflow-y: scroll; /* siempre muestra scrollbar, habilita clic medio */
            }

            body {
                min-height: 100%;
                font-family: 'Cinzel', 'Palatino Linotype', serif;
                background: var(--forest-deep);
                color: var(--text-primary);
                overflow-x: hidden;
                /* NO overflow: hidden en body — bloquea el scroll con rueda/clic medio */
            }

            /* ─── Background Scene ─────────────────────────────────────── */
            .arc-scene {
                position: fixed;
                inset: 0;
                z-index: 0;
                overflow: hidden;
            }

            /* Moon glow */
            .arc-moon {
                position: absolute;
                top: 12%;
                left: 50%;
                transform: translateX(-50%);
                width: 260px;
                height: 260px;
                border-radius: 50%;
                background: radial-gradient(circle at 40% 35%,
                    #e8f6ff 0%,
                    #c0e0f5 25%,
                    #7ab8dc 55%,
                    transparent 75%);
                box-shadow:
                    0 0 80px 40px rgba(180, 220, 250, 0.18),
                    0 0 200px 100px rgba(120, 180, 220, 0.08);
                animation: moonPulse 6s ease-in-out infinite;
            }

            @keyframes moonPulse {
                0%, 100% { opacity: 0.85; box-shadow: 0 0 80px 40px rgba(180,220,250,.18), 0 0 200px 100px rgba(120,180,220,.08); }
                50%       { opacity: 1;    box-shadow: 0 0 100px 55px rgba(180,220,250,.25), 0 0 240px 120px rgba(120,180,220,.12); }
            }

            /* Radial overlay gradient */
            .arc-scene::before {
                content: '';
                position: absolute;
                inset: 0;
                background:
                    radial-gradient(ellipse 70% 55% at 50% 20%, rgba(8,30,55,0.0) 0%, rgba(5,13,18,0.55) 100%),
                    linear-gradient(to bottom, rgba(5,13,18,0.0) 0%, rgba(5,13,18,0.85) 100%);
                z-index: 1;
            }

            /* Floating particles */
            .arc-particles {
                position: absolute;
                inset: 0;
                z-index: 2;
                pointer-events: none;
            }

            .arc-particle {
                position: absolute;
                border-radius: 50%;
                background: var(--teal-primary);
                opacity: 0;
                animation: particleDrift var(--dur, 8s) ease-in-out var(--delay, 0s) infinite;
            }

            @keyframes particleDrift {
                0%   { opacity: 0;    transform: translateY(0)    scale(1); }
                20%  { opacity: 0.55; }
                80%  { opacity: 0.3;  }
                100% { opacity: 0;    transform: translateY(-120px) scale(0.6); }
            }

            /* ─── Layout ────────────────────────────────────────────────── */
            .arc-wrapper {
                position: relative;
                z-index: 10;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            /* ─── Navbar ────────────────────────────────────────────────── */
            .arc-nav {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 18px 32px;
                border-bottom: 1px solid rgba(0, 201, 200, 0.08);
                background: rgba(5, 13, 18, 0.55);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
            }

            .arc-brand {
                display: flex;
                align-items: center;
                gap: 10px;
                font-size: 1.05rem;
                font-weight: 700;
                letter-spacing: 0.03em;
                color: var(--text-primary);
                text-decoration: none;
            }

            .arc-brand svg {
                color: var(--teal-primary);
                flex-shrink: 0;
            }

            .arc-nav-actions {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            /* Ghost button (Log in) */
            .arc-btn-ghost {
                padding: 8px 22px;
                border-radius: 8px;
                font-family: inherit;
                font-size: 0.82rem;
                font-weight: 600;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                text-decoration: none;
                color: var(--teal-primary);
                background: transparent;
                border: 1px solid var(--teal-border);
                cursor: pointer;
                transition: background var(--transition), box-shadow var(--transition), color var(--transition);
            }

            .arc-btn-ghost:hover {
                background: var(--teal-soft);
                box-shadow: 0 0 16px rgba(0, 201, 200, 0.18);
                color: #a0f5f4;
            }

            /* Outline button (Register) */
            .arc-btn-outline {
                padding: 8px 22px;
                border-radius: 8px;
                font-family: inherit;
                font-size: 0.82rem;
                font-weight: 600;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                text-decoration: none;
                color: #fff;
                background: linear-gradient(135deg, var(--teal-primary) 0%, var(--violet-accent) 100%);
                border: none;
                cursor: pointer;
                transition: opacity var(--transition), box-shadow var(--transition), transform var(--transition);
                box-shadow: 0 0 20px rgba(0, 201, 200, 0.22);
            }

            .arc-btn-outline:hover {
                opacity: 0.88;
                box-shadow: 0 0 32px rgba(0, 201, 200, 0.35), 0 4px 20px rgba(124, 58, 237, 0.25);
                transform: translateY(-1px);
            }

            /* ─── Hero ──────────────────────────────────────────────────── */
            .arc-hero {
                flex: 1;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-align: center;
                padding: 60px 24px 80px;
                gap: 0;
            }

            /* Tree icon badge */
            .arc-icon-badge {
                width: 58px;
                height: 58px;
                border-radius: 50%;
                background: rgba(0, 201, 200, 0.12);
                border: 1.5px solid var(--teal-border);
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 28px;
                color: var(--teal-primary);
                animation: badgePulse 3.5s ease-in-out infinite;
                box-shadow: 0 0 0 0 rgba(0, 201, 200, 0.3);
            }

            @keyframes badgePulse {
                0%, 100% { box-shadow: 0 0 0 0   rgba(0, 201, 200, 0.3); }
                50%       { box-shadow: 0 0 0 14px rgba(0, 201, 200, 0);   }
            }

            .arc-title {
                font-size: clamp(2.2rem, 6vw, 4.2rem);
                font-weight: 900;
                letter-spacing: -0.01em;
                line-height: 1.1;
                color: var(--teal-primary);
                text-shadow: 0 0 40px rgba(0, 201, 200, 0.35);
                margin-bottom: 18px;
                animation: fadeUp 0.9s ease both;
            }

            .arc-subtitle {
                font-family: 'Cinzel Decorative', 'Palatino Linotype', serif;
                font-size: clamp(0.85rem, 2vw, 1.05rem);
                font-style: italic;
                color: var(--text-muted);
                max-width: 560px;
                line-height: 1.65;
                margin-bottom: 52px;
                animation: fadeUp 0.9s 0.15s ease both;
            }

            @keyframes fadeUp {
                from { opacity: 0; transform: translateY(24px); }
                to   { opacity: 1; transform: translateY(0);    }
            }

            /* ─── Cards ─────────────────────────────────────────────────── */
            .arc-cards {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
                gap: 24px;
                width: 100%;
                max-width: 780px;
                animation: fadeUp 0.9s 0.28s ease both;
            }

            .arc-card {
                background: var(--forest-panel);
                border: 1px solid var(--teal-border);
                border-radius: var(--radius-card);
                padding: 36px 28px 32px;
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
                gap: 14px;
                backdrop-filter: blur(14px);
                -webkit-backdrop-filter: blur(14px);
                transition: border-color var(--transition), box-shadow var(--transition), transform var(--transition);
            }

            .arc-card:hover {
                border-color: rgba(0, 201, 200, 0.6);
                box-shadow: 0 0 40px rgba(0, 201, 200, 0.1), 0 8px 32px rgba(0, 0, 0, 0.4);
                transform: translateY(-3px);
            }

            .arc-card-icon {
                width: 50px;
                height: 50px;
                border-radius: 12px;
                background: rgba(0, 201, 200, 0.1);
                border: 1px solid var(--teal-border);
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--teal-primary);
                margin-bottom: 6px;
            }

            .arc-card-title {
                font-size: 1.18rem;
                font-weight: 700;
                color: var(--teal-primary);
                letter-spacing: 0.02em;
            }

            .arc-card-desc {
                font-family: 'EB Garamond', Georgia, serif;
                font-size: 0.92rem;
                color: var(--text-muted);
                line-height: 1.6;
                max-width: 240px;
            }

            /* Primary CTA (Traspasar el Umbral) */
            .arc-btn-primary {
                margin-top: 10px;
                width: 100%;
                padding: 14px 24px;
                border-radius: 10px;
                font-family: inherit;
                font-size: 0.8rem;
                font-weight: 800;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                text-decoration: none;
                color: #fff;
                background: linear-gradient(135deg, var(--teal-primary) 0%, var(--violet-accent) 100%);
                border: none;
                cursor: pointer;
                display: inline-block;
                text-align: center;
                transition: opacity var(--transition), box-shadow var(--transition), transform var(--transition);
                box-shadow: 0 0 24px rgba(0, 201, 200, 0.28), 0 4px 20px rgba(124, 58, 237, 0.2);
            }

            .arc-btn-primary:hover {
                opacity: 0.88;
                transform: translateY(-1px);
                box-shadow: 0 0 36px rgba(0, 201, 200, 0.42), 0 8px 28px rgba(124, 58, 237, 0.32);
            }

            /* Secondary CTA (Hacer el Juramento) */
            .arc-btn-secondary {
                margin-top: 10px;
                width: 100%;
                padding: 13px 24px;
                border-radius: 10px;
                font-family: inherit;
                font-size: 0.8rem;
                font-weight: 700;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                text-decoration: none;
                color: var(--teal-primary);
                background: transparent;
                border: 1.5px solid var(--teal-primary);
                cursor: pointer;
                display: inline-block;
                text-align: center;
                transition: background var(--transition), box-shadow var(--transition), transform var(--transition);
            }

            .arc-btn-secondary:hover {
                background: var(--teal-soft);
                box-shadow: 0 0 20px rgba(0, 201, 200, 0.18);
                transform: translateY(-1px);
            }

            /* ─── Side Icons ────────────────────────────────────────────── */
            .arc-side-icons {
                position: fixed;
                right: 20px;
                top: 50%;
                transform: translateY(-50%);
                display: flex;
                flex-direction: column;
                gap: 12px;
                z-index: 20;
            }

            .arc-side-icon {
                width: 42px;
                height: 42px;
                border-radius: 50%;
                background: rgba(8, 22, 36, 0.75);
                border: 1px solid var(--teal-border);
                display: flex;
                align-items: center;
                justify-content: center;
                color: var(--teal-primary);
                cursor: pointer;
                backdrop-filter: blur(8px);
                -webkit-backdrop-filter: blur(8px);
                transition: background var(--transition), box-shadow var(--transition);
            }

            .arc-side-icon:hover {
                background: var(--teal-soft);
                box-shadow: 0 0 16px rgba(0, 201, 200, 0.25);
            }

            /* ─── Responsive ────────────────────────────────────────────── */
            @media (max-width: 600px) {
                .arc-nav { padding: 14px 18px; }
                .arc-cards { grid-template-columns: 1fr; max-width: 360px; }
                .arc-side-icons { display: none; }
            }
        </style>

        {{-- Google Fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&family=Cinzel+Decorative:wght@400;700&family=EB+Garamond:ital,wght@0,400;0,500;1,400&display=swap" rel="stylesheet">
    </head>

    <body>

        {{-- ── Background Scene ───────────────────────────────────────── --}}
        <div class="arc-scene" aria-hidden="true">
            <div class="arc-moon"></div>

            {{-- Floating particles --}}
            <div class="arc-particles" id="arcParticles"></div>
        </div>

        {{-- ── Main Wrapper ────────────────────────────────────────────── --}}
        <div class="arc-wrapper">

            {{-- ── Navbar ──────────────────────────────────────────────── --}}
            <nav class="arc-nav">
                <a href="{{ url('/') }}" class="arc-brand">
                    {{-- Book icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            aria-hidden="true">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                    </svg>
                    {{ config('app.name', 'Grimorio del Bosque') }}
                </a>

                <div class="arc-nav-actions">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="arc-btn-ghost">{{ __('Iniciar sesión') }}</a>
                    @endif

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="arc-btn-outline">{{ __('Crear una cuenta') }}</a>
                    @endif
                </div>
            </nav>

            {{-- ── Hero ─────────────────────────────────────────────────── --}}
            <main class="arc-hero">

                {{-- Tree badge --}}
                <div class="arc-icon-badge" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 14l-5-10-5 10h3v6h4v-6z"/>
                    </svg>
                </div>

                <h1 class="arc-title">Grimorio del Bosque</h1>

                <p class="arc-subtitle">
                    "En el silencio del follaje eterno, donde cada hoja es un secreto y cada
                    sombra una verdad, resguardamos la sabiduría que el tiempo olvidó."
                </p>

                {{-- Cards --}}
                <div class="arc-cards">

                    {{-- Card 1: Entrar al Santuario --}}
                    <div class="arc-card">
                        <div class="arc-card-icon" aria-hidden="true">
                            {{-- Key icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="7.5" cy="15.5" r="5.5"/>
                                <path d="M21 2l-9.6 9.6"/>
                                <path d="M15.5 7.5l3 3 3-3-3-3"/>
                            </svg>
                        </div>
                        <h2 class="arc-card-title">Entrar al Santuario</h2>
                        <p class="arc-card-desc">
                            Retoma tu lugar como guardián y consulta los tomos sagrados del archivo.
                        </p>
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="arc-btn-primary">
                                {{ __('Traspasar el Umbral') }}
                            </a>
                        @endif
                    </div>

                    {{-- Card 2: Iniciarse como Guardián --}}
                    <div class="arc-card">
                        <div class="arc-card-icon" aria-hidden="true">
                            {{-- Shield icon --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            </svg>
                        </div>
                        <h2 class="arc-card-title">Iniciarse como Guardián</h2>
                        <p class="arc-card-desc">
                            Comienza tu viaje académico y espiritual bajo la guía de la Luna Azul.
                        </p>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="arc-btn-secondary">
                                {{ __('Hacer el Juramento') }}
                            </a>
                        @endif
                    </div>

                </div>{{-- /.arc-cards --}}
            </main>{{-- /.arc-hero --}}

        </div>{{-- /.arc-wrapper --}}

        {{-- ── Side Icons ───────────────────────────────────────────────── --}}
        <aside class="arc-side-icons" aria-hidden="true">
            <button class="arc-side-icon" title="Viento">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9.59 4.59A2 2 0 1 1 11 8H2m10.59 11.41A2 2 0 1 0 14 16H2m15.73-8.27A2.5 2.5 0 1 1 19.5 12H2"/>
                </svg>
            </button>
            <button class="arc-side-icon" title="Luna">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                </svg>
            </button>
            <button class="arc-side-icon" title="Objetivo">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/>
                    <circle cx="12" cy="12" r="6"/>
                    <circle cx="12" cy="12" r="2"/>
                </svg>
            </button>
        </aside>

        {{-- ── Particle Script ─────────────────────────────────────────── --}}
        <script>
            (function () {
                const container = document.getElementById('arcParticles');
                const count = 18;
                for (let i = 0; i < count; i++) {
                    const p = document.createElement('span');
                    p.className = 'arc-particle';
                    const size = Math.random() * 4 + 2;
                    p.style.cssText = `
                        width:${size}px;
                        height:${size}px;
                        left:${Math.random() * 100}%;
                        bottom:${Math.random() * 40}%;
                        --dur:${7 + Math.random() * 9}s;
                        --delay:${Math.random() * 8}s;
                    `;
                    container.appendChild(p);
                }
            })();
        </script>

    </body>
</html>