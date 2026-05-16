<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ __('Log in') }} - {{ config('app.name', 'Bosque') }}</title>
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">
        @fonts
        <style>
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

            body {
                min-height: 100vh;
                background-color: #0b1628;
                background-image:
                    radial-gradient(ellipse 60% 50% at 20% 40%, rgba(10, 80, 80, 0.18) 0%, transparent 70%),
                    radial-gradient(ellipse 50% 60% at 80% 60%, rgba(10, 50, 90, 0.15) 0%, transparent 70%);
                font-family: 'Georgia', 'Times New Roman', serif;
                color: #c8d8e8;
                display: flex;
                flex-direction: column;
            }

            /* NAV */
            .top-nav {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 1.25rem 2rem;
            }

            .site-title {
                font-size: 1.05rem;
                font-weight: 600;
                color: #d0e8e0;
                letter-spacing: 0.03em;
            }

            /* PAGE */
            .page-body {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem 1rem 3rem;
            }

            /* CARD */
            .card {
                background: rgba(16, 30, 52, 0.82);
                border: 1px solid rgba(100, 200, 170, 0.15);
                border-radius: 16px;
                padding: 2.5rem 2rem 2rem;
                width: 100%;
                max-width: 440px;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            /* ICON */
            .card-icon {
                margin-bottom: 1.5rem;
                color: rgba(0, 201, 200, 0.42);
            }

            .card-icon svg {
                width: 52px;
                height: 52px;
            }

            /* HEADINGS */
            .card-title {
                font-size: 1.65rem;
                font-weight: 700;
                color: #e8f4ef;
                text-align: center;
                line-height: 1.25;
                margin-bottom: 0.5rem;
            }

            .card-subtitle {
                font-size: 0.875rem;
                color: #7a9eaa;
                text-align: center;
                margin-bottom: 2rem;
                font-family: sans-serif;
            }

            /* FORM */
            .form {
                width: 100%;
                display: flex;
                flex-direction: column;
                gap: 1.25rem;
            }

            .field {
                display: flex;
                flex-direction: column;
                gap: 0.4rem;
            }

            .field label {
                font-size: 0.82rem;
                color: #8fb0c0;
                font-family: sans-serif;
                letter-spacing: 0.02em;
            }

            .input-wrap {
                display: flex;
                align-items: center;
                background: rgba(10, 22, 42, 0.7);
                border: 1px solid rgba(100, 200, 170, 0.2);
                border-radius: 8px;
                padding: 0 0.9rem;
                transition: border-color 0.15s;
            }

            .input-wrap:focus-within {
                border-color: rgba(62, 207, 170, 0.5);
            }

            .input-wrap svg {
                width: 16px;
                height: 16px;
                color: #4a7a8a;
                flex-shrink: 0;
                margin-right: 0.6rem;
            }

            .input-wrap input {
                flex: 1;
                background: transparent;
                border: none;
                outline: none;
                color: #c8d8e8;
                font-size: 0.9rem;
                font-family: sans-serif;
                padding: 0.75rem 0;
            }

            .input-wrap input::placeholder {
                color: #3a5a6a;
            }

            /* REMEMBER + FORGOT */
            .form-row {
                display: flex;
                align-items: center;
                justify-content: space-between;
                font-family: sans-serif;
                font-size: 0.82rem;
            }

            .remember-label {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                color: #7a9eaa;
                cursor: pointer;
            }

            .remember-label input[type="checkbox"] {
                width: 14px;
                height: 14px;
                accent-color: #3ecfaa;
                cursor: pointer;
            }

            .forgot-link {
                color: #3ecfaa;
                text-decoration: none;
                transition: color 0.15s;
            }

            .forgot-link:hover { color: #6fe0c0; }

            /* ERROR */
            .error-msg {
                font-family: sans-serif;
                font-size: 0.8rem;
                color: #e07070;
                margin-top: -0.5rem;
            }

            /* SUBMIT */
            .submit-btn {
                width: 100%;
                padding: 0.85rem;
                background: rgba(62, 207, 170, 0.15);
                border: 1px solid rgba(62, 207, 170, 0.4);
                border-radius: 8px;
                color: #d0f0e8;
                font-size: 0.78rem;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                font-family: sans-serif;
                font-weight: 600;
                cursor: pointer;
                transition: background 0.15s, border-color 0.15s;
                margin-top: 0.25rem;
            }

            .submit-btn:hover {
                background: rgba(0, 201, 200, 0.42);
                border-color: rgba(62, 207, 170, 0.65);
            }

            /* DIVIDER */
            .divider {
                width: 100%;
                display: flex;
                align-items: center;
                gap: 0.75rem;
                margin: 0.5rem 0;
            }

            .divider-line {
                flex: 1;
                height: 1px;
                background: rgba(100, 200, 170, 0.1);
            }

            .divider-text {
                font-family: sans-serif;
                font-size: 0.72rem;
                color: #3a5a6a;
                letter-spacing: 0.1em;
                text-transform: uppercase;
            }

            /* OAUTH BUTTONS */
            .oauth-row {
                width: 100%;
                display: flex;
                gap: 0.75rem;
            }

            .oauth-btn {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
                padding: 0.65rem 1rem;
                background: rgba(10, 22, 42, 0.6);
                border: 1px solid rgba(100, 200, 170, 0.18);
                border-radius: 8px;
                color: #8fb0c0;
                font-family: sans-serif;
                font-size: 0.82rem;
                text-decoration: none;
                transition: border-color 0.15s, background 0.15s;
                cursor: pointer;
            }

            .oauth-btn:hover {
                border-color: rgba(100, 200, 170, 0.35);
                background: rgba(100, 200, 170, 0.06);
            }

            .oauth-btn svg {
                width: 16px;
                height: 16px;
                flex-shrink: 0;
            }

            /* REGISTER LINK */
            .register-text {
                font-family: sans-serif;
                font-size: 0.82rem;
                color: #4a6a7a;
                margin-top: 0.5rem;
            }

            .register-text a {
                color: #3ecfaa;
                text-decoration: none;
                font-weight: 500;
                transition: color 0.15s;
            }

            .register-text a:hover { color: #6fe0c0; }

            /* FOOTER */
            .page-footer {
                text-align: center;
                padding: 1.25rem 1rem 2rem;
                font-family: sans-serif;
                font-size: 0.72rem;
                color: #2a4050;
                display: flex;
                flex-direction: column;
                gap: 0.4rem;
            }

            .footer-links {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.6rem;
                flex-wrap: wrap;
            }

            .footer-links a {
                color: #2a4050;
                text-decoration: none;
                transition: color 0.15s;
            }

            .footer-links a:hover { color: #7aacb8; }
        </style>
    </head>
    <body>

        <nav class="top-nav">
            <span class="site-title">{{ config('app.name', 'Laravel') }}</span>
        </nav>

        <div class="page-body">
            <div class="card">

                {{-- Icon --}}
                <div class="card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 6.5C2 5.12 3.12 4 4.5 4H12v16H4.5C3.12 20 2 18.88 2 17.5V6.5Z"/>
                        <path d="M12 4h7.5C20.88 4 22 5.12 22 6.5v11c0 1.38-1.12 2.5-2.5 2.5H12V4Z"/>
                        <path d="M12 4v16"/>
                    </svg>
                </div>

                <h1 class="card-title">{{ __('Welcome back') }}</h1>
                <p class="card-subtitle">{{ __('Inicia sesión para continuar tu viaje.') }}</p>

                {{-- Session errors --}}
                @if ($errors->any())
                    <div class="error-msg" style="width:100%; margin-bottom:0.5rem;">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- Status (e.g. password reset) --}}
                @if (session('status'))
                    <div style="width:100%; margin-bottom:0.75rem; font-family:sans-serif; font-size:0.8rem; color:#3ecfaa;">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="form">
                    @csrf

                    {{-- Email --}}
                    <div class="field">
                        <label for="email">{{ __('Correo electrónico') }}</label>
                        <div class="input-wrap">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="4" width="20" height="16" rx="2"/>
                                <path d="m2 7 10 7 10-7"/>
                            </svg>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="correo@ejemplo.com"
                                required
                                autofocus
                                autocomplete="email"
                            >
                        </div>
                        @error('email')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Contraseña --}}
                    <div class="field">
                        <label for="password">{{ __('Contraseña') }}</label>
                        <div class="input-wrap">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2"/>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                            </svg>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                placeholder="••••••••••••"
                                required
                                autocomplete="current-password"
                            >
                        </div>
                        @error('password')
                            <span class="error-msg">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Recuérdame + ¿Olvidaste tu contraseña? --}}
                    <div class="form-row">
                        <label class="remember-label">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            {{ __('Recuérdame') }}
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">
                                {{ __('¿Olvidaste tu contraseña?') }}
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="submit-btn" onclick="this.disabled=true; this.innerText='Iniciando sesión...'; this.form.submit();">
                        {{ __('Iniciar sesión') }}
                    </button>
                </form>

                {{-- Register link --}}
                @if (Route::has('register'))
                    <p class="register-text" style="margin-top:1.5rem;">
                        {{ __("¿No tienes una cuenta?") }}
                        <a href="{{ route('register') }}">{{ __('Crea una') }}</a>
                    </p>
                @endif

            </div>
        </div>

        <footer class="page-footer">
            <div>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}</div>
            <div class="footer-links">
                <a href="#" target="_blank">Grimorio</a>
                <span>&bull;</span>
                <a href="#" target="_blank">Bosque</a>
            </div>
        </footer>

    </body>
</html>