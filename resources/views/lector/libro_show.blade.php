<x-layouts::app_lector>

<div style="max-width: 920px; margin: 30px auto; padding: 20px;">

    <a href="{{ route('lector.libros.index') }}" style="display: inline-flex; align-items: center; gap: 6px; font-size: 13px; color: #555; text-decoration: none; margin-bottom: 20px;">
        ← Volver
    </a>

    {{-- HEADER --}}
    <div style="display: flex; gap: 24px; align-items: flex-start; margin-bottom: 32px; flex-wrap: wrap;">

        {{-- Imagen principal --}}
        <div style="width: 150px; height: 170px; border-radius: 12px; background: #f0f0f0; border: 0.5px solid #e0e0e0; flex-shrink: 0; overflow: hidden; display: flex; align-items: center; justify-content: center;">
            @if($libro->imagenes && count($libro->imagenes) > 0)
                <img src="{{ asset('storage/' . $libro->imagenes[0]) }}" style="width:100%; height:100%; object-fit:cover;" alt="Portada del libro">
            @else
                <span style="font-size: 40px; color: #bbb;">📖</span>
            @endif
        </div>

        {{-- Info principal --}}
        <div style="flex: 1; min-width: 220px;">

            <h1 style="font-size: 28px; font-weight: 700; margin: 0 0 10px; line-height: 1.25; color: #1a1a1a;">{{ $libro->titulo }}</h1>

            <p style="font-size: 13px; color: #555; margin: 0 0 20px; line-height: 1.6;">{{ $libro->sinopsis }}</p>

            {{-- Stats row --}}
            @php
                $totalEjemplares = $libro->ejemplares->where('estado', '!=', 'perdido')->count();
                $disponiblesCount = $libro->ejemplares->where('estado', 'disponible')->count();
                $pct = $totalEjemplares > 0 ? round($disponiblesCount / $totalEjemplares * 100) : 0;
            @endphp
            <div style="display: flex; gap: 28px; flex-wrap: wrap; align-items: center;">
                <div>
                    <div class="showlibro-stat-label">Ejemplares activos</div>
                    <div class="showlibro-stat-value" style="color: #1D9E75;">{{ $totalEjemplares }} Ejemplares</div>
                </div>
                <div style="min-width: 130px;">
                    <div class="showlibro-stat-label" style="display: flex; justify-content: space-between;">
                        <span>Disponibilidad</span>
                        <span>{{ $pct }}%</span>
                    </div>
                    <div class="showlibro-progress-bar-bg" style="margin-top: 4px;">
                        <div class="showlibro-progress-bar-fill" style="width: {{ $pct }}%;"></div>
                    </div>
                </div>
                <div>
                    <div class="showlibro-stat-label">Autor</div>
                    <div class="showlibro-stat-value">{{ $libro->autor }}</div>
                </div>
                <div>
                    <div class="showlibro-stat-label">Editorial</div>
                    <div class="showlibro-stat-value">{{ $libro->editorial }}</div>
                </div>
                <div>
                    <div class="showlibro-stat-label">Publicación</div>
                    <div class="showlibro-stat-value">{{ $libro->fecha_publicacion }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- CATEGORÍAS --}}
    @if($libro->categorias->count() > 0)
    <div style="margin-bottom: 28px;">
        <p class="showlibro-section-title" style="margin-bottom: 10px;">Categorías</p>
        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            @foreach($libro->categorias as $categoria)
                <span class="showlibro-badge {{ $loop->even ? 'showlibro-badge-restricted' : 'showlibro-badge-mythic' }}">{{ strtoupper($categoria->nombre) }}</span>
            @endforeach
        </div>
    </div>
    @endif

    {{-- EJEMPLARES --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; gap: 12px; flex-wrap: wrap;">
        <p class="showlibro-section-title">Manifestaciones físicas (Ejemplares)</p>
        @if($disponiblesCount > 0)
            @if(auth()->user()->prestamos_blocked)
                <div style="display: inline-flex; flex-direction: column; align-items: flex-end; gap: 6px;">
                    <div style="cursor: not-allowed;">
                        <button class="showlibro-loan-btn" disabled style="pointer-events: none; opacity: 0.5;">
                            Solicitar préstamo — {{ $disponiblesCount }} disponibles
                        </button>
                    </div>
                    <span style="font-size: 12px; color: #A32D2D;">
                        ⚠ No puedes solicitar préstamos debido a bloqueos anteriores por no devolver tus préstamos a tiempo. Por favor, contacta con el personal de la biblioteca para más información.
                    </span>
                </div>
            @else
                <button class="showlibro-loan-btn" onclick="window.location.href='{{ route('lector.prestamos.create', ['libro_id' => $libro->id]) }}'">
                    Solicitar préstamo — {{ $disponiblesCount }} disponibles
                </button>
            @endif
        @endif
    </div>

    @if($libro->ejemplares->count() > 0)
        <div class="showlibro-copies-grid">
            @foreach($libro->ejemplares as $ej)
                @php
                    $estado = $ej->estado;
                    // Normalizar estado a una de las tres clases CSS
                    if ($estado === 'disponible') {
                        $cardClass  = 'disponible';
                        $pillClass  = 'status-disponible';
                        $pillLabel  = 'DISPONIBLE';
                    } elseif ($estado === 'prestado') {
                        $cardClass  = 'prestado';
                        $pillClass  = 'status-prestado';
                        $pillLabel  = 'EN PRÉSTAMO';
                    } else {
                        $cardClass  = 'restaurando';
                        $pillClass  = 'status-restaurando';
                        $pillLabel  = strtoupper($estado);
                    }
                @endphp
                <div class="showlibro-copy-card {{ $cardClass }}">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 4px;">
                        {{-- Icono por estado --}}
                        @if($estado === 'disponible')
                            <span style="font-size:18px;">📖</span>
                        @elseif($estado === 'prestado')
                            <span style="font-size:18px;">👤</span>
                        @else
                            <span style="font-size:18px;">🔧</span>
                        @endif
                        <span class="showlibro-status-pill {{ $pillClass }}">{{ $pillLabel }}</span>
                    </div>

                    <p class="showlibro-copy-code">
                        Ejemplar #{{ $ej->codigo ?? $ej->id }}
                    </p>

                    @if($ej->observaciones ?? false)
                        <p class="showlibro-copy-desc">{{ $ej->observaciones }}</p>
                    @endif

                    @if($ej->ubicacion ?? false)
                        <p class="showlibro-copy-meta">
                            📍 {{ $ej->ubicacion }}
                        </p>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="showlibro-empty-state">
            No hay ejemplares registrados para este libro.
        </div>
    @endif

</div>

</x-layouts::app_lector>