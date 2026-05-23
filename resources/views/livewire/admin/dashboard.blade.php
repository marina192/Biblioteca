<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500;600&display=swap');

    .dash-root {
        font-family: 'DM Sans', sans-serif;
        background: #f0f4f8;
        min-height: 100vh;
        padding: 2rem;
        box-sizing: border-box;
        color: #1a1a2e;
    }

    /* ── Header ── */
    .dash-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 1.75rem;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .dash-header-titles h1 {
        font-family: 'Playfair Display', serif;
        font-size: 2.2rem;
        font-weight: 700;
        margin: 0 0 0.25rem;
        line-height: 1.1;
        color: #0f172a;
    }

    .dash-header-titles p {
        margin: 0;
        font-size: 0.875rem;
        color: #64748b;
        font-weight: 300;
    }

    .dash-status-badge {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 999px;
        padding: 0.4rem 1rem;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #475569;
        white-space: nowrap;
        align-self: flex-start;
        margin-top: 0.25rem;
    }

    .dash-status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: #06b6d4;
        box-shadow: 0 0 6px #06b6d4aa;
        animation: dash-pulse 2s infinite;
    }

    @keyframes dash-pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.4; }
    }

    /* ── KPI Cards Row ── */
    .dash-kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.25rem;
    }

    .dash-kpi-card {
        background: #fff;
        border-radius: 1rem;
        padding: 1.25rem 1.5rem 1.5rem;
        border: 1px solid #e8edf3;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .dash-kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.07);
    }

    .dash-kpi-card--alert {
        background: #fff5f5;
        border-color: #fecaca;
    }

    .dash-kpi-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .dash-kpi-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }

    .dash-kpi-icon--blue   { background: #1e293b; color: #fff; }
    .dash-kpi-icon--violet { background: #ede9fe; color: #7c3aed; }
    .dash-kpi-icon--teal   { background: #e0f2fe; color: #0369a1; }
    .dash-kpi-icon--red    { background: #fee2e2; color: #dc2626; }

    .dash-kpi-badge {
        font-size: 0.7rem;
        font-weight: 600;
        padding: 0.15rem 0.5rem;
        border-radius: 999px;
        white-space: nowrap;
    }

    .dash-kpi-badge--green  { color: #16a34a; background: #dcfce7; }
    .dash-kpi-badge--violet { color: #7c3aed; background: #ede9fe; }
    .dash-kpi-badge--slate  { color: #475569; background: #f1f5f9; }
    .dash-kpi-badge--red    { color: #dc2626; background: #fee2e2; font-weight: 700; letter-spacing: 0.04em; }

    .dash-kpi-label {
        font-size: 0.65rem;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #94a3b8;
        margin-top: 0.25rem;
    }

    .dash-kpi-value {
        font-size: 2.25rem;
        font-weight: 700;
        line-height: 1;
        color: #0f172a;
    }

    .dash-kpi-value--alert {
        color: #dc2626;
    }

    .dash-kpi-sub {
        font-size: 0.75rem;
        color: #94a3b8;
        font-style: italic;
    }

    .dash-kpi-bar {
        height: 3px;
        border-radius: 2px;
        background: #e2e8f0;
        overflow: hidden;
        margin-top: 0.25rem;
    }

    .dash-kpi-bar-fill {
        height: 100%;
        border-radius: 2px;
    }

    .dash-kpi-bar-fill--cyan   { background: linear-gradient(90deg, #06b6d4, #818cf8); width: 65%; }
    .dash-kpi-bar-fill--violet { background: linear-gradient(90deg, #818cf8, #c084fc); width: 45%; }

    .dash-kpi-avatars {
        display: flex;
        align-items: center;
        gap: -4px;
        margin-top: 0.25rem;
    }

    .dash-kpi-avatar {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        border: 2px solid #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.6rem;
        font-weight: 700;
        color: #fff;
        margin-left: -6px;
    }

    .dash-kpi-avatar:first-child { margin-left: 0; }
    .dash-kpi-avatar--a { background: #06b6d4; }
    .dash-kpi-avatar--b { background: #818cf8; }
    .dash-kpi-avatar--c { background: #c084fc; }

    .dash-kpi-avatar-more {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        border: 2px solid #fff;
        background: #e2e8f0;
        font-size: 0.55rem;
        font-weight: 700;
        color: #64748b;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: -6px;
    }

    /* ── Charts Row ── */
    .dash-charts-row {
        display: grid;
        grid-template-columns: 1fr 0.7fr;
        gap: 1rem;
        margin-bottom: 1.25rem;
    }

    @media (max-width: 768px) {
        .dash-charts-row { grid-template-columns: 1fr; }
    }

    .dash-card {
        background: #fff;
        border-radius: 1rem;
        padding: 1.5rem;
        border: 1px solid #e8edf3;
    }

    .dash-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
    }

    .dash-card-title {
        font-size: 1rem;
        font-weight: 600;
        color: #0f172a;
        margin: 0;
    }

    .dash-legend {
        display: flex;
        gap: 1rem;
        font-size: 0.72rem;
        color: #64748b;
    }

    .dash-legend-item {
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .dash-legend-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
    }

    .dash-legend-dot--cyan   { background: #06b6d4; }
    .dash-legend-dot--hollow { width: 7px; height: 7px; border-radius: 50%; border: 2px solid #94a3b8; background: transparent; }

    .dash-chart-wrap {
        position: relative;
        height: 180px;
    }

    /* ── Popular Books ── */
    .dash-books-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .dash-book-item {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }

    .dash-book-item-top {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
    }

    .dash-book-name {
        font-size: 0.82rem;
        font-weight: 500;
        color: #1e293b;
    }

    .dash-book-count {
        font-size: 0.82rem;
        font-weight: 700;
        color: #06b6d4;
    }

    .dash-book-bar {
        height: 5px;
        background: #f1f5f9;
        border-radius: 3px;
        overflow: hidden;
    }

    .dash-book-bar-fill {
        height: 100%;
        border-radius: 3px;
    }

    .dash-book-bar-fill--1 { background: #06b6d4; }
    .dash-book-bar-fill--2 { background: #818cf8; }
    .dash-book-bar-fill--3 { background: #22d3ee; }
    .dash-book-bar-fill--4 { background: #1e293b; }

    /* ── Recent Activity ── */
    .dash-activity-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
    }

    .dash-activity-link {
        font-size: 0.78rem;
        color: #06b6d4;
        text-decoration: none;
        font-weight: 500;
    }

    .dash-activity-link:hover { text-decoration: underline; }

    .dash-activity-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .dash-activity-item {
        display: flex;
        gap: 0.75rem;
        align-items: flex-start;
    }

    .dash-activity-icon-wrap {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .dash-activity-icon-wrap--blue   { background: #e0f2fe; }
    .dash-activity-icon-wrap--slate  { background: #f1f5f9; }
    .dash-activity-icon-wrap--red    { background: #fee2e2; }

    .dash-activity-body {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
    }

    .dash-activity-title {
        font-size: 0.82rem;
        font-weight: 600;
        color: #0f172a;
        line-height: 1.3;
    }

    .dash-activity-meta {
        font-size: 0.72rem;
        color: #94a3b8;
    }

    .dash-activity-tag {
        display: inline-block;
        font-size: 0.62rem;
        font-weight: 700;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        padding: 0.15rem 0.5rem;
        border-radius: 999px;
        margin-top: 0.2rem;
    }

    .dash-activity-tag--blue { background: #e0f2fe; color: #0369a1; }
    .dash-activity-tag--gray { background: #f1f5f9; color: #475569; }
    .dash-activity-tag--red  { background: #fee2e2; color: #dc2626; }
</style>

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