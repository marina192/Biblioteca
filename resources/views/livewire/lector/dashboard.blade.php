<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,400&family=DM+Sans:wght@300;400;500;600&display=swap');

    /* ── Base ── */
    .dash-root {
        font-family: 'DM Sans', sans-serif;
        background: #f0f4f8;
        min-height: 100vh;
        padding: 2rem;
        box-sizing: border-box;
        color: #1a1a2e;
    }

    /* ── Welcome Banner ── */
    .dash-welcome {
        position: relative;
        background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 60%, #0e4f6e 100%);
        border-radius: 1.25rem;
        padding: 2.5rem 2rem 2rem;
        margin-bottom: 1.5rem;
        overflow: hidden;
        color: #fff;
    }

    .dash-welcome-orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        pointer-events: none;
    }

    .dash-welcome-orb--1 {
        width: 260px; height: 260px;
        background: rgba(6, 182, 212, 0.25);
        top: -80px; right: -60px;
    }

    .dash-welcome-orb--2 {
        width: 180px; height: 180px;
        background: rgba(129, 140, 248, 0.2);
        bottom: -60px; left: 30%;
    }

    .dash-welcome-eyebrow {
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #06b6d4;
        margin: 0 0 0.6rem;
    }

    .dash-welcome-title {
        font-family: 'Playfair Display', serif;
        font-size: 2rem;
        font-weight: 700;
        margin: 0 0 0.5rem;
        line-height: 1.15;
        position: relative;
    }

    .dash-welcome-sub {
        font-size: 0.9rem;
        color: #94a3b8;
        margin: 0 0 1.75rem;
        font-weight: 300;
        max-width: 520px;
        line-height: 1.6;
        position: relative;
    }

    .dash-welcome-pills {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
        position: relative;
    }

    .dash-welcome-pill {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 999px;
        padding: 0.4rem 0.85rem;
        font-size: 0.78rem;
        font-weight: 500;
        color: #e2e8f0;
        backdrop-filter: blur(4px);
    }

    .dash-welcome-pill-dot {
        width: 7px; height: 7px;
        border-radius: 50%;
    }

    .dash-welcome-pill-dot--cyan   { background: #06b6d4; box-shadow: 0 0 6px #06b6d4; }
    .dash-welcome-pill-dot--violet { background: #818cf8; }
    .dash-welcome-pill-dot--amber  { background: #fbbf24; }

    /* ── Stats strip ── */
    .dash-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));
        gap: 1rem;
        margin-bottom: 1.25rem;
    }

    .dash-stat-card {
        background: #fff;
        border-radius: 1rem;
        padding: 1.25rem 1.5rem 1.4rem;
        border: 1px solid #e8edf3;
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .dash-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.07);
    }

    .dash-stat-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .dash-stat-icon {
        width: 34px; height: 34px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem;
    }

    .dash-stat-icon--dark   { background: #1e293b; color: #fff; }
    .dash-stat-icon--cyan   { background: #e0f9ff; color: #0891b2; }
    .dash-stat-icon--violet { background: #ede9fe; color: #7c3aed; }
    .dash-stat-icon--amber  { background: #fef9c3; color: #b45309; }

    .dash-stat-badge {
        font-size: 0.65rem;
        font-weight: 600;
        padding: 0.15rem 0.45rem;
        border-radius: 999px;
    }

    .dash-stat-badge--green  { background: #dcfce7; color: #16a34a; }
    .dash-stat-badge--cyan   { background: #e0f9ff; color: #0891b2; }
    .dash-stat-badge--violet { background: #ede9fe; color: #7c3aed; }
    .dash-stat-badge--amber  { background: #fef9c3; color: #b45309; }

    .dash-stat-label {
        font-size: 0.62rem;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: #94a3b8;
        margin-top: 0.2rem;
    }

    .dash-stat-value {
        font-size: 2rem;
        font-weight: 700;
        line-height: 1;
        color: #0f172a;
    }

    .dash-stat-hint {
        font-size: 0.72rem;
        color: #94a3b8;
    }

    /* ── Charts row ── */
    .dash-charts-row {
        display: grid;
        grid-template-columns: 1fr 0.65fr;
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
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 1.25rem;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .dash-card-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #0f172a;
        margin: 0;
    }

    .dash-card-sub {
        font-size: 0.72rem;
        color: #94a3b8;
        margin: 0.2rem 0 0;
        font-weight: 300;
    }

    .dash-card-tag {
        font-size: 0.65rem;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        padding: 0.2rem 0.6rem;
        border-radius: 999px;
        background: #f1f5f9;
        color: #64748b;
        white-space: nowrap;
        align-self: flex-start;
    }

    .dash-chart-wrap {
        position: relative;
        height: 220px;
    }

    .dash-chart-wrap--donut {
        height: 230px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ── Suggestion strip ── */
    .dash-suggest-section {
        margin-bottom: 0;
    }

    .dash-suggest-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .dash-suggest-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #0f172a;
        margin: 0;
    }

    .dash-suggest-link {
        font-size: 0.78rem;
        color: #06b6d4;
        text-decoration: none;
        font-weight: 500;
    }

    .dash-suggest-link:hover { text-decoration: underline; }

    .dash-suggest-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }

    .dash-book-card {
        background: #fff;
        border: 1px solid #e8edf3;
        border-radius: 1rem;
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
    }

    .dash-book-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.07);
    }

    .dash-book-cover {
        width: 48px; height: 64px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        margin-bottom: 0.25rem;
        flex-shrink: 0;
    }

    .dash-book-cover--1 { background: linear-gradient(135deg, #e0f2fe, #bae6fd); }
    .dash-book-cover--2 { background: linear-gradient(135deg, #ede9fe, #ddd6fe); }
    .dash-book-cover--3 { background: linear-gradient(135deg, #fef9c3, #fde68a); }
    .dash-book-cover--4 { background: linear-gradient(135deg, #dcfce7, #bbf7d0); }

    .dash-book-title {
        font-size: 0.82rem;
        font-weight: 600;
        color: #0f172a;
        line-height: 1.3;
    }

    .dash-book-author {
        font-size: 0.72rem;
        color: #94a3b8;
    }

    .dash-book-cat {
        display: inline-block;
        font-size: 0.62rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 0.15rem 0.5rem;
        border-radius: 999px;
        background: #f1f5f9;
        color: #475569;
        margin-top: auto;
    }
</style>

{{-- ══════════════════════════════════════════ --}}
<div class="dash-root">

    {{-- ── Welcome Banner ── --}}
    <div class="dash-welcome">
        <div class="dash-welcome-orb dash-welcome-orb--1"></div>
        <div class="dash-welcome-orb dash-welcome-orb--2"></div>

        <p class="dash-welcome-eyebrow">✦ Biblioteca · Portal del Lector</p>
        <h1 class="dash-welcome-title">
            Bienvenido/a,<br>{{ Auth::user()->name ?? 'Lector' }} 👋
        </h1>
        <p class="dash-welcome-sub">
            Aquí puedes explorar qué está leyendo la comunidad, descubrir las categorías
            más populares y encontrar tu próxima lectura favorita.
        </p>
        <div class="dash-welcome-pills">
            <span class="dash-welcome-pill">
                <span class="dash-welcome-pill-dot dash-welcome-pill-dot--cyan"></span>
                Catálogo disponible
            </span>
            <span class="dash-welcome-pill">
                <span class="dash-welcome-pill-dot dash-welcome-pill-dot--violet"></span>
                {{ $prestamosActivos ?? 0 }} préstamos activos
            </span>
            <span class="dash-welcome-pill">
                <span class="dash-welcome-pill-dot dash-welcome-pill-dot--amber"></span>
                {{ $totalLibros ?? 0 }} títulos en colección
            </span>
        </div>
    </div>

    {{-- ── Stats strip ── --}}
    <div class="dash-stats-grid">

        <div class="dash-stat-card">
            <div class="dash-stat-top">
                <div class="dash-stat-icon dash-stat-icon--dark">📚</div>
                <span class="dash-stat-badge dash-stat-badge--green">Disponibles</span>
            </div>
            <div class="dash-stat-label">Libros en Colección</div>
            <div class="dash-stat-value">{{ number_format($totalLibros ?? 0) }}</div>
            <div class="dash-stat-hint">Títulos únicos en catálogo</div>
        </div>

        <div class="dash-stat-card">
            <div class="dash-stat-top">
                <div class="dash-stat-icon dash-stat-icon--cyan">⚡</div>
                <span class="dash-stat-badge dash-stat-badge--cyan">En curso</span>
            </div>
            <div class="dash-stat-label">Mis Préstamos Activos</div>
            <div class="dash-stat-value">{{ $misPrestamosActivos ?? 0 }}</div>
            <div class="dash-stat-hint">Libros que tienes ahora</div>
        </div>

        <div class="dash-stat-card">
            <div class="dash-stat-top">
                <div class="dash-stat-icon dash-stat-icon--violet">📖</div>
                <span class="dash-stat-badge dash-stat-badge--violet">Historial</span>
            </div>
            <div class="dash-stat-label">Libros Leídos</div>
            <div class="dash-stat-value">{{ $librosLeidos ?? 0 }}</div>
            <div class="dash-stat-hint">Préstamos devueltos</div>
        </div>

        <div class="dash-stat-card">
            <div class="dash-stat-top">
                <div class="dash-stat-icon dash-stat-icon--amber">🏷️</div>
                <span class="dash-stat-badge dash-stat-badge--amber">Géneros</span>
            </div>
            <div class="dash-stat-label">Categorías</div>
            <div class="dash-stat-value">{{ $totalCategorias ?? 0 }}</div>
            <div class="dash-stat-hint">Géneros disponibles</div>
        </div>

    </div>

    {{-- ── Charts ── --}}
    <div class="dash-charts-row">

        {{-- Bar chart: libros más leídos ── --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <div>
                    <h2 class="dash-card-title">Libros más populares</h2>
                    <p class="dash-card-sub">Los títulos más prestados por la comunidad</p>
                </div>
                <span class="dash-card-tag">Este año</span>
            </div>
            <div class="dash-chart-wrap">
                <canvas id="librosChart"></canvas>
            </div>
        </div>

        {{-- Doughnut chart: categorías ── --}}
        <div class="dash-card">
            <div class="dash-card-header">
                <div>
                    <h2 class="dash-card-title">Categorías populares</h2>
                    <p class="dash-card-sub">Géneros más prestados</p>
                </div>
            </div>
            <div class="dash-chart-wrap dash-chart-wrap--donut">
                <canvas id="categoriasChart"></canvas>
            </div>
        </div>

    </div>

    {{-- ── Suggested books strip ── --}}
    <div class="dash-suggest-section">
        <div class="dash-suggest-header">
            <h2 class="dash-suggest-title">✦ Descubre nuevos títulos</h2>
            <a href="{{ route('lector.libros.index') }}" class="dash-suggest-link">Ver catálogo completo →</a>
        </div>
        <div class="dash-suggest-grid">
            @forelse($librosMasLeidos->take(4) as $titulo => $total)
            @php $covers = ['--1','--2','--3','--4']; $i = $loop->index; @endphp
            <div class="dash-book-card">
                <div class="dash-book-cover dash-book-cover{{ $covers[$i % 4] }}">📗</div>
                <div class="dash-book-title">{{ $titulo }}</div>
                <div class="dash-book-author">{{ $total }} préstamos</div>
                <span class="dash-book-cat">Popular</span>
            </div>
            @empty
            <p style="color:#94a3b8; font-size:0.85rem;">Sin datos aún.</p>
            @endforelse
        </div>
    </div>

</div>
{{-- ══════════════════════════════════════════ --}}

<script>
    const dashLibrosLabels     = @json(array_keys($librosMasLeidos->toArray()));
    const dashLibrosData       = @json(array_values($librosMasLeidos->toArray()));
    const dashCategoriasLabels = @json(array_keys($categoriasMasPopulares->toArray()));
    const dashCategoriasData   = @json(array_values($categoriasMasPopulares->toArray()));

    let dashLibrosChart     = null;
    let dashCategoriasChart = null;

    function dashInitCharts() {
        // Destruir instancias previas (wire:navigate)
        if (dashLibrosChart)     { dashLibrosChart.destroy();     dashLibrosChart = null; }
        if (dashCategoriasChart) { dashCategoriasChart.destroy(); dashCategoriasChart = null; }

        // ── Bar chart: libros más leídos ──
        const librosCanvas = document.getElementById('librosChart');
        if (librosCanvas) {
            dashLibrosChart = new Chart(librosCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: dashLibrosLabels,
                    datasets: [{
                        label: 'Préstamos',
                        data: dashLibrosData,
                        backgroundColor: [
                            'rgba(6,182,212,0.75)',
                            'rgba(129,140,248,0.75)',
                            'rgba(34,211,238,0.75)',
                            'rgba(251,191,36,0.75)',
                            'rgba(167,139,250,0.75)',
                        ],
                        borderRadius: 6,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: ctx => ` ${ctx.parsed.y} préstamos`
                            }
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { size: 10 },
                                color: '#94a3b8',
                                maxRotation: 30,
                            }
                        },
                        y: {
                            grid: { color: '#f1f5f9' },
                            ticks: { font: { size: 10 }, color: '#94a3b8' },
                            beginAtZero: true,
                        }
                    }
                }
            });
        }

        // ── Doughnut chart: categorías ──
        const catCanvas = document.getElementById('categoriasChart');
        if (catCanvas) {
            dashCategoriasChart = new Chart(catCanvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: dashCategoriasLabels,
                    datasets: [{
                        label: 'Préstamos',
                        data: dashCategoriasData,
                        backgroundColor: [
                            'rgba(6,182,212,0.8)',
                            'rgba(129,140,248,0.8)',
                            'rgba(251,191,36,0.8)',
                            'rgba(34,211,238,0.8)',
                            'rgba(167,139,250,0.8)',
                        ],
                        borderColor: '#fff',
                        borderWidth: 3,
                        hoverOffset: 6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: { size: 10 },
                                color: '#64748b',
                                boxWidth: 10,
                                padding: 12,
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: ctx => ` ${ctx.label}: ${ctx.parsed} préstamos`
                            }
                        }
                    }
                }
            });
        }
    }

    dashInitCharts();
    document.addEventListener('livewire:navigated', dashInitCharts);
</script>