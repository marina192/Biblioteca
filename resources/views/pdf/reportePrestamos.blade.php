<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
    /* ===== BASE ===== */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 11px;
        background-color: #0a0f1a;
        color: #9ab8cc;
    }

    /* ===== ENCABEZADO ===== */
    .header {
        background-color: #060c16;
        border-bottom: 1px solid #1e3a5f;
        padding: 20px 32px 16px;
    }
    .header-inner {
        display: table;
        width: 100%;
    }
    .header-logo {
        display: table-cell;
        vertical-align: middle;
        width: 50%;
    }
    .header-meta {
        display: table-cell;
        vertical-align: middle;
        text-align: right;
        width: 50%;
    }
    .logo-circle {
        display: inline-block;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #0a1525;
        border: 1px solid #1e3a5f;
        vertical-align: middle;
        margin-right: 10px;
        text-align: center;
        line-height: 36px;
        font-size: 16px;
        color: #3a7aba;
    }
    .logo-name {
        display: inline-block;
        vertical-align: middle;
    }
    .logo-name h1 {
        font-size: 15px;
        font-weight: bold;
        color: #a8c8e8;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 2px;
    }
    .logo-name p {
        font-size: 9px;
        color: #3a5a7a;
        letter-spacing: 3px;
        text-transform: uppercase;
    }
    .header-meta .report-title {
        font-size: 11px;
        color: #5a8aaa;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 4px;
    }
    .header-meta .report-date {
        font-size: 10px;
        color: #3a5a6a;
        font-style: italic;
    }

    /* ===== SEPARADOR BOSQUE ===== */
    .forest-divider {
        height: 6px;
        background-color: #0a0f1a;
        border-top: 1px solid #0d1f35;
    }

    /* ===== CUERPO ===== */
    .body {
        padding: 24px 32px;
    }

    /* ===== SECCIÓN ===== */
    .section {
        margin-bottom: 28px;
    }
    .section-header {
        border-bottom: 1px solid #1a2d45;
        padding-bottom: 6px;
        margin-bottom: 10px;
    }
    .section-title-row {
        display: table;
        width: 100%;
    }
    .section-dot-wrap {
        display: table-cell;
        vertical-align: middle;
        width: 12px;
    }
    .section-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }
    .dot-active   { background-color: #3a7a5a; }
    .dot-expired  { background-color: #7a3a2a; }
    .dot-returned { background-color: #2a4a7a; }
    .section-title-cell {
        display: table-cell;
        vertical-align: middle;
    }
    .section-title {
        font-size: 10px;
        font-weight: bold;
        color: #6a9abb;
        letter-spacing: 3px;
        text-transform: uppercase;
    }
    .section-count {
        display: table-cell;
        vertical-align: middle;
        text-align: right;
        font-size: 9px;
        color: #3a6a5a;
        letter-spacing: 1px;
    }

    /* ===== TABLA ===== */
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 10.5px;
    }
    thead th {
        font-size: 9px;
        font-weight: bold;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #2a4a6a;
        padding: 6px 8px;
        text-align: left;
        border-bottom: 1px solid #101e2e;
    }
    tbody td {
        padding: 8px 8px;
        border-bottom: 1px solid #0d1826;
        color: #7a9ab8;
        vertical-align: middle;
    }
    tbody tr:nth-child(odd) td {
        background-color: #0c1220;
    }
    tbody td:first-child { color: #1e3a5a; font-size: 9px; }
    tbody td:nth-child(2) { color: #b8d0e0; font-weight: bold; }
    .empty-row td {
        text-align: center;
        padding: 16px;
        color: #1e3a5a;
        font-style: italic;
    }

    /* ===== BADGES ===== */
    .badge {
        padding: 2px 7px;
        border-radius: 8px;
        font-size: 9px;
        font-weight: bold;
        display: inline-block;
    }
    .badge-active   { background-color: #0d2218; color: #4aaa7a; border: 1px solid #1a4a2a; }
    .badge-expired  { background-color: #220e0a; color: #aa5a3a; border: 1px solid #4a1a0a; }
    .badge-returned { background-color: #0a1020; color: #4a7aaa; border: 1px solid #1a2a4a; }
    .date-overdue   { color: #aa5a3a; font-weight: bold; }

    /* ===== PIE DE PÁGINA ===== */
    .footer {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: #060c16;
        border-top: 1px solid #101e2e;
        padding: 10px 32px;
    }
    .footer-inner {
        display: table;
        width: 100%;
    }
    .footer-left {
        display: table-cell;
        font-size: 9px;
        color: #1e3a5a;
        font-style: italic;
        width: 33%;
    }
    .footer-center {
        display: table-cell;
        font-size: 9px;
        color: #1a2e45;
        text-align: center;
        letter-spacing: 4px;
        text-transform: uppercase;
        width: 33%;
    }
    .footer-right {
        display: table-cell;
        font-size: 9px;
        color: #1e3a5a;
        text-align: right;
        width: 33%;
    }
    .footer-page::after {
        content: counter(page);
    }
    @page {
        margin-bottom: 40px;
    }
</style>
</head>
<body>

{{-- ENCABEZADO --}}
<div class="header">
    <div class="header-inner">
        <div class="header-logo">
            <span class="logo-circle">◎</span>
            <span class="logo-name">
                <h1>Edda</h1>
                <p>Sistema de gestión</p>
            </span>
        </div>
        <div class="header-meta">
            <p class="report-title">{{ $titulo }}</p>
            <p class="report-date">Generado el {{ now()->isoFormat('D [de] MMMM [de] YYYY · HH:mm') }}</p>
        </div>
    </div>
</div>
<div class="forest-divider"></div>

<div class="body">

    {{-- ===== PRÉSTAMOS ACTIVOS ===== --}}
    <div class="section">
        <div class="section-header">
            <div class="section-title-row">
                <div class="section-dot-wrap">
                    <span class="section-dot dot-active"></span>
                </div>
                <div class="section-title-cell">
                    <span class="section-title">Préstamos activos</span>
                </div>
                <div class="section-count">{{ $prestamosActivos->count() }} registros</div>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th width="25">#</th>
                    <th>Libro</th>
                    <th width="25">ID de Usuario</th>
                    <th width="85">Usuario</th>
                    <th width="80">Préstamo</th>
                    <th width="90">Dev. esperada</th>
                    <th width="65">Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prestamosActivos as $i => $p)
                <tr>
                    <td>{{ str_pad($p->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $p->ejemplar->libro->titulo }}</td>
                    <td>{{ $p->user->id ?? '-' }}</td>
                    <td>{{ $p->user->name ?? 'Usuario eliminado' }}</td>
                    <td>{{ $p->fecha_prestamo->format('d/m/Y') }}</td>
                    <td>{{ $p->fecha_devolucion_esperada->format('d/m/Y') }}</td>
                    <td><span class="badge badge-active">● Activo</span></td>
                </tr>
                @empty
                <tr class="empty-row"><td colspan="6">Sin resultados para los filtros aplicados</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ===== PRÉSTAMOS VENCIDOS ===== --}}
    <div class="section">
        <div class="section-header">
            <div class="section-title-row">
                <div class="section-dot-wrap">
                    <span class="section-dot dot-expired"></span>
                </div>
                <div class="section-title-cell">
                    <span class="section-title">Préstamos vencidos</span>
                </div>
                <div class="section-count">{{ $prestamosExpirados->count() }} registros</div>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th width="25">#</th>
                    <th>Libro</th>
                    <th width="25">ID de Usuario</th>
                    <th width="85">Usuario</th>
                    <th width="80">Préstamo</th>
                    <th width="90">Dev. esperada</th>
                    <th width="65">Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prestamosExpirados as $p)
                <tr>
                    <td>{{ str_pad($p->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $p->ejemplar->libro->titulo }}</td>
                    <td>{{ $p->user->id ?? '-' }}</td>
                    <td>{{ $p->user->name ?? 'Usuario eliminado' }}</td>
                    <td>{{ $p->fecha_prestamo->format('d/m/Y') }}</td>
                    <td class="date-overdue">{{ $p->fecha_devolucion_esperada->format('d/m/Y') }}</td>
                    <td><span class="badge badge-expired">● Vencido</span></td>
                </tr>
                @empty
                <tr class="empty-row"><td colspan="6">Sin resultados para los filtros aplicados</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ===== PRÉSTAMOS DEVUELTOS ===== --}}
    <div class="section">
        <div class="section-header">
            <div class="section-title-row">
                <div class="section-dot-wrap">
                    <span class="section-dot dot-returned"></span>
                </div>
                <div class="section-title-cell">
                    <span class="section-title">Préstamos devueltos</span>
                </div>
                <div class="section-count">{{ $prestamosPasados->count() }} registros</div>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th width="25">#</th>
                    <th>Libro</th>
                    <th width="25">ID de Usuario</th>
                    <th width="85">Usuario</th>
                    <th width="80">Préstamo</th>
                    <th width="90">Dev. esperada</th>
                    <th width="80">Devuelto el</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prestamosPasados as $p)
                <tr>
                    <td>{{ str_pad($p->id, 3, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $p->ejemplar->libro->titulo }}</td>
                    <td>{{ $p->user->id ?? '-' }}</td>
                    <td>{{ $p->user->name ?? 'Usuario eliminado' }}</td>
                    <td>{{ $p->fecha_prestamo->format('d/m/Y') }}</td>
                    <td>{{ $p->fecha_devolucion_esperada->format('d/m/Y') }}</td>
                    <td><span class="badge badge-returned">{{ $p->fecha_devolucion->format('d/m/Y') }}</span></td>
                </tr>
                @empty
                <tr class="empty-row"><td colspan="6">Sin resultados para los filtros aplicados</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- PIE DE PÁGINA --}}
<div class="footer">
    <div class="footer-inner">
        <span class="footer-left">Edda — Sistema de Gestión</span>
        <span class="footer-center">✦ &nbsp; Arcana &nbsp; ✦</span>
        <span class="footer-right">Pág. <span class="footer-page"></span> &nbsp;·&nbsp; Confidencial</span>
    </div>
</div>

</body>
</html>