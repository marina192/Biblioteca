<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="dash-root">

    {{-- ── Header ── --}}
    <div class="dash-header">
        <div class="dash-header-titles">
            <h1>Vista del Guardián</h1>
            <p>Monitoreando el pulso de la Biblioteca Ancestral.</p>
        </div>
        <div class="dash-status-badge">
            <span class="dash-status-dot"></span>
            Sistema en línea
        </div>
    </div>

    {{-- ── KPI Cards ── --}}
    <div class="dash-kpi-grid">

        {{-- Ejemplares --}}
        <div class="dash-kpi-card">
            <div class="dash-kpi-top">
                <div class="dash-kpi-icon dash-kpi-icon--blue">📚</div>
                <span class="dash-kpi-badge dash-kpi-badge--green">+ este ciclo</span>
            </div>
            <div class="dash-kpi-label">Total Ejemplares</div>
            <div class="dash-kpi-value">{{ number_format($ejemplares) }}</div>
            <div class="dash-kpi-bar"><div class="dash-kpi-bar-fill dash-kpi-bar-fill--cyan"></div></div>
        </div>

        {{-- Préstamos activos --}}
        <div class="dash-kpi-card">
            <div class="dash-kpi-top">
                <div class="dash-kpi-icon dash-kpi-icon--violet">⚡</div>
                <span class="dash-kpi-badge dash-kpi-badge--violet">Resonancia activa</span>
            </div>
            <div class="dash-kpi-label">Préstamos Activos</div>
            <div class="dash-kpi-value">{{ $prestamosActivos }}</div>
            <div class="dash-kpi-bar"><div class="dash-kpi-bar-fill dash-kpi-bar-fill--violet"></div></div>
        </div>

        {{-- Bibliotecarios --}}
        <div class="dash-kpi-card">
            <div class="dash-kpi-top">
                <div class="dash-kpi-icon dash-kpi-icon--teal">🎓</div>
                <span class="dash-kpi-badge dash-kpi-badge--slate">{{ $bibliotecarios }} en servicio</span>
            </div>
            <div class="dash-kpi-label">Bibliotecarios</div>
            <div class="dash-kpi-value">{{ $bibliotecarios }}</div>
            <div class="dash-kpi-avatars">
                <div class="dash-kpi-avatar dash-kpi-avatar--a">A</div>
                <div class="dash-kpi-avatar dash-kpi-avatar--b">B</div>
                <div class="dash-kpi-avatar dash-kpi-avatar--c">C</div>
                <div class="dash-kpi-avatar-more">+{{ max(0, $bibliotecarios - 3) }}</div>
            </div>
        </div>

        {{-- Préstamos vencidos --}}
        <div class="dash-kpi-card dash-kpi-card--alert">
            <div class="dash-kpi-top">
                <div class="dash-kpi-icon dash-kpi-icon--red">⚠️</div>
                <span class="dash-kpi-badge dash-kpi-badge--red">Requiere Atención</span>
            </div>
            <div class="dash-kpi-label">Préstamos Vencidos</div>
            <div class="dash-kpi-value dash-kpi-value--alert">
                {{ $prestamosVencidos }}
            </div>
            <div class="dash-kpi-sub">Sellos de retención caducando…</div>
        </div>

    </div>

    {{-- ── Charts Row ── --}}
    <div class="dash-charts-row">

        {{-- Line chart: préstamos por mes --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <h2 class="dash-card-title">Préstamos Mensuales</h2>
                <div class="dash-legend">
                    <span class="dash-legend-item">
                        <span class="dash-legend-dot dash-legend-dot--cyan"></span> Activos
                    </span>
                    <span class="dash-legend-item">
                        <span class="dash-legend-dot dash-legend-dot--hollow"></span> Archivo
                    </span>
                </div>
            </div>
            <div class="dash-chart-wrap">
                <canvas id="prestamosChart"></canvas>
            </div>
        </div>

        {{-- Popular books --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <h2 class="dash-card-title">Libros Más Populares</h2>
            </div>
            <div class="dash-books-list" id="dashBooksList">
                @php
                    $colors = ['--1','--2','--3','--4'];
                    $idx = 0;
                @endphp
                @foreach($librosMasLeidos as $titulo => $cantidad)
                    @if($idx < 4)
                    <div class="dash-book-item">
                        <div class="dash-book-item-top">
                            <span class="dash-book-name">{{ $titulo }}</span>
                            <span class="dash-book-count">{{ $cantidad }}</span>
                        </div>
                        <div class="dash-book-bar">
                            <div class="dash-book-bar-fill dash-book-bar-fill{{ $colors[$idx] }}"
                                 style="width: {{ $librosMasLeidos->max() > 0 ? round(($cantidad / $librosMasLeidos->max()) * 100) : 0 }}%">
                            </div>
                        </div>
                    </div>
                    @php $idx++; @endphp
                    @endif
                @endforeach
            </div>
        </div>

    </div>

</div>

<script>
    // Datos desde PHP — ordenados por mes numérico, traducidos al español
    const dashLabels   = @json(array_values($prestamosPorMes->pluck('mes')->toArray()));
    const dashActivos  = @json(array_values($prestamosPorMes->pluck('total')->toArray()));
    const dashArchivo  = @json(array_values($prestamosDevueltosPorMes->pluck('total')->toArray()));

    let dashChartInstance = null;

    function dashInitChart() {
        const canvas = document.getElementById('prestamosChart');
        if (!canvas) return;

        // Destruir instancia previa si existe (wire:navigate reutiliza el DOM)
        if (dashChartInstance) {
            dashChartInstance.destroy();
            dashChartInstance = null;
        }

        dashChartInstance = new Chart(canvas.getContext('2d'), {
            type: 'line',
            data: {
                labels: dashLabels,
                datasets: [
                    {
                        label: 'Activos',
                        data: dashActivos,
                        borderColor: '#06b6d4',
                        backgroundColor: 'rgba(6,182,212,0.08)',
                        borderWidth: 2.5,
                        pointRadius: 0,
                        tension: 0.45,
                        fill: true,
                    },
                    {
                        label: 'Archivo',
                        data: dashArchivo,
                        borderColor: '#cbd5e1',
                        borderWidth: 1.5,
                        borderDash: [4, 4],
                        pointRadius: 0,
                        tension: 0.45,
                        fill: false,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10 }, color: '#94a3b8' }
                    },
                    y: {
                        grid: { color: '#f1f5f9' },
                        ticks: { font: { size: 10 }, color: '#94a3b8' }
                    }
                }
            }
        });
    }

    // Inicializar al cargar la página normalmente
    dashInitChart();

    // Reinicializar tras navegación SPA de Livewire (wire:navigate)
    document.addEventListener('livewire:navigated', dashInitChart);
</script>