<x-layouts::auth :title="__('Registro')">
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

        .page-body {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem 3rem;
        }

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

        .card-icon { margin-bottom: 1.5rem; color: rgba(0, 201, 200, 0.42); }
        .card-icon svg { width: 52px; height: 52px; }

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

        .arc-form {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        .arc-field {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
        }

        .arc-field label {
            font-size: 0.82rem;
            color: #8fb0c0;
            font-family: sans-serif;
            letter-spacing: 0.02em;
        }

        .arc-input-wrap {
            display: flex;
            align-items: center;
            background: rgba(10, 22, 42, 0.7);
            border: 1px solid rgba(100, 200, 170, 0.2);
            border-radius: 8px;
            padding: 0 0.9rem;
            transition: border-color 0.15s;
        }

        .arc-input-wrap:focus-within {
            border-color: rgba(62, 207, 170, 0.5);
        }

        .arc-input-wrap svg {
            width: 16px;
            height: 16px;
            color: #4a7a8a;
            flex-shrink: 0;
            margin-right: 0.6rem;
        }

        .arc-input-wrap input {
            flex: 1;
            background: transparent;
            border: none;
            outline: none;
            color: #c8d8e8;
            font-size: 0.9rem;
            font-family: sans-serif;
            padding: 0.75rem 0;
        }

        .arc-input-wrap input::placeholder { color: #3a5a6a; }

        .arc-toggle-pw {
            background: none;
            border: none;
            cursor: pointer;
            color: #4a7a8a;
            padding: 0;
            display: flex;
            align-items: center;
            transition: color 0.15s;
        }

        .arc-toggle-pw:hover { color: #3ecfaa; }
        .arc-toggle-pw svg { width: 16px; height: 16px; }

        .arc-error {
            font-family: sans-serif;
            font-size: 0.8rem;
            color: #e07070;
        }

        .arc-status {
            font-family: sans-serif;
            font-size: 0.8rem;
            color: #3ecfaa;
            text-align: center;
            width: 100%;
            margin-bottom: 0.25rem;
        }

        .arc-submit {
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

        .arc-submit:hover {
            background: rgba(62, 207, 170, 0.25);
            border-color: rgba(62, 207, 170, 0.65);
        }

        .arc-footer-text {
            font-family: sans-serif;
            font-size: 0.82rem;
            color: #4a6a7a;
            margin-top: 1.5rem;
        }

        .arc-footer-text a {
            color: #3ecfaa;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.15s;
        }

        .arc-footer-text a:hover { color: #6fe0c0; }
    </style>

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

            <h1 class="card-title">{{ __('Crea una cuenta') }}</h1>
            <p class="card-subtitle">{{ __('Ingresa tus datos a continuación para comenzar') }}</p>

            {{-- Session status --}}
            @if (session('status'))
                <p class="arc-status">{{ session('status') }}</p>
            @endif

            <form method="POST" action="{{ route('register.store') }}" class="arc-form">
                @csrf

                {{-- Name --}}
                <div class="arc-field">
                    <label for="name">{{ __('Nombre') }}</label>
                    <div class="arc-input-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="8" r="4"/>
                            <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
                        </svg>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            placeholder="{{ __('Full name') }}"
                            required
                            autofocus
                            autocomplete="name"
                        >
                    </div>
                    @error('name')
                        <span class="arc-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="arc-field">
                    <label for="email">{{ __('Correo electrónico') }}</label>
                    <div class="arc-input-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="4" width="20" height="16" rx="2"/>
                            <path d="m2 7 10 7 10-7"/>
                        </svg>
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            placeholder="email@example.com"
                            required
                            autocomplete="email"
                        >
                    </div>
                    @error('email')
                        <span class="arc-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="arc-field">
                    <label for="password">{{ __('Contraseña') }}</label>
                    <div class="arc-input-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input
                            id="password"
                            name="password"
                            type="password"
                            placeholder="{{ __('Contraseña') }}"
                            required
                            autocomplete="new-password"
                        >
                        <button type="button" class="arc-toggle-pw" onclick="togglePw('password', this)" aria-label="Toggle password visibility">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12S5 5 12 5s11 7 11 7-4 7-11 7S1 12 1 12Z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <span class="arc-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="arc-field">
                    <label for="password_confirmation">{{ __('Confirmar contraseña') }}</label>
                    <div class="arc-input-wrap">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            placeholder="{{ __('Confirmar contraseña') }}"
                            required
                            autocomplete="new-password"
                        >
                        <button type="button" class="arc-toggle-pw" onclick="togglePw('password_confirmation', this)" aria-label="Toggle password visibility">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12S5 5 12 5s11 7 11 7-4 7-11 7S1 12 1 12Z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <span class="arc-error">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="arc-submit" data-test="register-user-button">
                    {{ __('Crear cuenta') }}
                </button>
            </form>

            <p class="arc-footer-text">
                {{ __('¿Ya tienes una cuenta?') }}
                <a href="{{ route('login') }}" wire:navigate>{{ __('Inicia sesión') }}</a>
            </p>

        </div>
    </div>

    <script>
        function togglePw(fieldId, btn) {
            var input = document.getElementById(fieldId);
            var isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            var eyeOpen = '<path d="M1 12S5 5 12 5s11 7 11 7-4 7-11 7S1 12 1 12Z"/><circle cx="12" cy="12" r="3"/>';
            var eyeClosed = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/>';
            btn.querySelector('svg').innerHTML = isHidden ? eyeClosed : eyeOpen;
        }
    </script>
</x-layouts::auth>