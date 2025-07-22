<?= $this->extend('layouts/ciudadano') ?>
<?= $this->section('content') ?>


<!-- Banner principal con efecto de gradiente mejorado -->
<section class="welcome-section text-white py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3 animate__animated animate__bounceIn">
                    Bienvenido al Portal Ciudadano
                </h1>
                <p class="lead mb-4 animate__animated animate__fadeIn animate__delay-1s">
                    Registra tus reclamos y mira tus reportes en línea de manera sencilla.
                </p>
                <div class="d-flex flex-wrap gap-3 animate__animated animate__fadeIn animate__delay-2s">
                    <a href="<?= site_url('ciudadano/nuevo-reclamo') ?>" class="btn btn-light btn-lg px-4 shadow-sm">
                        <i class="bi bi-plus-circle me-2"></i> Crear nuevo reclamo
                    </a>
                    <a href="<?= site_url('ciudadano/mis-reclamos') ?>" class="btn btn-outline-light btn-lg px-4 shadow-sm">
                        <i class="bi bi-list-check me-2"></i> Ver mis reclamos
                    </a>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-center animate__animated animate__fadeIn">
                <img src="<?= base_url('assets/images/portal-ciudadano.png') ?>" alt="Ilustración portal ciudadano" class="img-fluid floating" style="max-height: 200px;">
            </div>
        </div>
    </div>
</section>


<!-- Estadísticas dinámicas -->
<div class="container my-5">
    <div class="dashboard-section">
        <h2 class="section-title">
            <i class="bi bi-speedometer2"></i> Resumen de mis reclamos
        </h2>
        <div class="stats-grid">
            <div class="stat-card pending">
                <div class="stat-icon">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
                <div class="stat-value"><?= esc($estadisticas['pendientes']) ?></div>
                <div class="stat-label">Pendientes</div>
            </div>

            <div class="stat-card in-progress">
                <div class="stat-icon">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="stat-value"><?= esc($estadisticas['en_proceso']) ?></div>
                <div class="stat-label">En proceso</div>
            </div>

            <div class="stat-card resolved">
                <div class="stat-icon">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
                <div class="stat-value"><?= esc($estadisticas['solucionados']) ?></div>
                <div class="stat-label">Resueltos</div>
            </div>
        </div>
    </div>
</div>

<!-- Reclamos recientes -->
<div class="container my-5">
    <div class="dashboard-section">
        <div class="section-header">
            <h2 class="section-title">
                <i class="bi bi-clock-history"></i> Mis reclamos recientes
            </h2>
            <a href="<?= site_url('ciudadano/mis-reclamos') ?>" class="view-all">
                Ver todos <i class="bi bi-chevron-right"></i>
            </a>
        </div>

        <div class="complaints-list">
            <?php $reclamosMostrados = array_slice($reclamos, 0, 3); ?>
            <?php foreach ($reclamosMostrados as $reclamo): ?>
                <div class="complaint-card">
                    <div class="complaint-id"><?= esc($reclamo['id']) ?></div>
                    <div class="complaint-date"><?= esc(date('d/m/Y', strtotime($reclamo['fecha']))) ?></div>
                    <h3 class="complaint-title"><?= esc(substr($reclamo['descripcion'], 0, 60)) ?></h3>
                    <div class="complaint-status <?= esc($reclamo['estado']) ?>">
                        <?= esc(ucfirst($reclamo['estado'])) ?>
                    </div>
                    <a href="<?= site_url('ciudadano/ver-respuesta/' . $reclamo['id']) ?>" class="complaint-action">
                        <i class="bi bi-eye"></i> Ver detalles
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Acciones rápidas -->
<div class="container my-5">
    <div class="dashboard-section">
        <h2 class="section-title">
            <i class="bi bi-lightning-charge"></i> Acciones rápidas
        </h2>
        <div class="quick-actions">
            <a href="<?= site_url('ciudadano/tramites') ?>" class="action-card">
                <div class="action-icon info">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <h3>Consultar trámites</h3>
                <p>Revisa los trámites disponibles y sus requisitos</p>
                <span class="action-link">Ver trámites <i class="bi bi-arrow-right"></i></span>
            </a>

            <a href="<?= site_url('ciudadano/preguntas_frecuentes') ?>" class="action-card">
                <div class="action-icon primary">
                    <i class="bi bi-question-circle"></i>
                </div>
                <h3>Preguntas frecuentes</h3>
                <p>Encuentra respuestas a las dudas más comunes</p>
                <span class="action-link">Ver ayuda <i class="bi bi-arrow-right"></i></span>
            </a>

            <a href="<?= site_url('ciudadano/perfil') ?>" class="action-card">
                <div class="action-icon warning">
                    <i class="bi bi-person"></i>
                </div>
                <h3>Mi perfil</h3>
                <p>Actualiza tus datos personales y preferencias</p>
                <span class="action-link">Editar perfil <i class="bi bi-arrow-right"></i></span>
            </a>
        </div>
    </div>
</div>

<!-- Noticias y anuncios -->
<div class="container my-5">
    <div class="dashboard-section">
        <h2 class="section-title">
            <i class="bi bi-megaphone"></i> Noticias y anuncios
        </h2>

        <div class="news-grid">
            <div class="news-card">
                <div class="news-image" style="background-image: url('<?= base_url('assets/images/sistema-seguimiento.png') ?>');"></div>
                <div class="news-content">
                    <div class="news-meta">
                        <span class="news-category">Novedad</span>
                        <span class="news-date">Hoy</span>
                    </div>
                    <h3 class="news-title">Nuevo sistema de seguimiento</h3>
                    <p class="news-excerpt">Implementamos mejoras en el sistema de seguimiento de reclamos...</p>
                    <div class="news-footer">
                        <a href="#" class="read-more">Leer más</a>
                        <span class="reading-time">2 min</span>
                    </div>
                </div>
            </div>

            <div class="news-card">
                <div class="news-image" style="background-image: url('<?= base_url('assets/images/horario-extendido.png') ?>');"></div>
                <div class="news-content">
                    <div class="news-meta">
                        <span class="news-category">Aviso</span>
                        <span class="news-date">Ayer</span>
                    </div>
                    <h3 class="news-title">Horario extendido de atención</h3>
                    <p class="news-excerpt">Ampliaremos nuestro horario de atención al ciudadano...</p>
                    <div class="news-footer">
                        <a href="#" class="read-more">Leer más</a>
                        <span class="reading-time">3 min</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="#" class="btn-outline">
                <i class="bi bi-newspaper"></i> Ver todas las noticias
            </a>
        </div>
    </div>
</div>

<style>
    /* Estilos generales */
    .dashboard-section {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 24px;
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .welcome-section {
    background: #0d6efd;       /* color base */
    background-image: none;    /* por si había algo heredado */
}



    
    /* Estadísticas */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 16px;
    }
    
    .stat-card {
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        transition: transform 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 1.5rem;
    }
    
    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 4px;
    }
    
    .stat-label {
        color: #6c757d;
        margin-bottom: 8px;
    }
    
    .stat-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    /* Colores para estadísticas */
    .pending {
        background-color: #fff5f5;
        border-left: 4px solid #dc3545;
    }
    .pending .stat-icon {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
    .pending .stat-badge {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
    
    .in-progress {
        background-color: #fff9e6;
        border-left: 4px solid #fd7e14;
    }
    .in-progress .stat-icon {
        background-color: rgba(253, 126, 20, 0.1);
        color: #fd7e14;
    }
    .in-progress .stat-badge {
        background-color: rgba(253, 126, 20, 0.1);
        color: #fd7e14;
    }
    
    .resolved {
        background-color: #f0fff4;
        border-left: 4px solid #28a745;
    }
    .resolved .stat-icon {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
    .resolved .stat-badge {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
    
    /* Acciones rápidas */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }
    
    .action-card {
        display: block;
        padding: 20px;
        border-radius: 10px;
        background: white;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
        text-decoration: none;
        color: inherit;
    }
    
    .action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        border-color: transparent;
    }
    
    .action-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 16px;
        font-size: 1.5rem;
    }
    
    .action-card h3 {
        font-size: 1.1rem;
        margin-bottom: 8px;
        color: #2c3e50;
    }
    
    .action-card p {
        color: #6c757d;
        margin-bottom: 16px;
        font-size: 0.9rem;
    }
    
    .action-link {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .action-card:hover .action-link {
        transform: translateX(3px);
    }
    
    /* Colores para acciones */
    .info {
        background-color: rgba(23, 162, 184, 0.1);
        color: #17a2b8;
    }
    .primary {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
    }
    .warning {
        background-color: rgba(255, 193, 7, 0.1);
        color: #ffc107;
    }
    
    /* Reclamos recientes */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
    }
    
    .view-all {
        display: flex;
        align-items: center;
        gap: 4px;
        font-size: 0.9rem;
        color: #6c757d;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .view-all:hover {
        color: #0d6efd;
    }
    
    .complaints-list {
        display: grid;
        gap: 12px;
    }
    
    .complaint-card {
        display: grid;
        grid-template-columns: 120px 100px 1fr auto auto;
        align-items: center;
        gap: 16px;
        padding: 16px;
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    @media (max-width: 992px) {
        .complaint-card {
            grid-template-columns: 1fr 1fr;
            grid-template-rows: auto auto auto;
        }
    }
    
    .complaint-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    
    .complaint-id {
        font-weight: 600;
        color: #2c3e50;
    }
    
    .complaint-date {
        color: #6c757d;
        font-size: 0.9rem;
    }
    
    .complaint-title {
        font-size: 1rem;
        margin: 0;
        color: #495057;
    }
    
    .complaint-status {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        text-align: center;
    }
    
    .complaint-action {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s ease;
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
    }
    
    .complaint-action:hover {
        background-color: rgba(13, 110, 253, 0.2);
    }
    
    /* Estados de reclamos */
    .pending {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
    .in-progress {
        background-color: rgba(253, 126, 20, 0.1);
        color: #fd7e14;
    }
    .resolved {
        background-color: rgba(40, 167, 69, 0.1);
        color: #28a745;
    }
    
    /* Noticias */
    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }
    
    .news-card {
    display: flex;
    flex-direction: row;
    border: 1px solid #eee;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    background-color: #fff;
}
    
    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    
    .news-image {
    width: 120px;
    height: 120px;
    background-size: contain;
    background-position: center;
    background-repeat: no-repeat;
    flex-shrink: 0;
    margin: 15px;
    border-radius: 10px;
    background-color: #f8f9fa;
}
    
    .news-content {
    padding: 1rem;
    flex-grow: 1;
}
    
    .news-meta {
    font-size: 0.85rem;
    color: #6c757d;
    margin-bottom: 0.5rem;
}
    
    .news-category {
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .news-date {
        color: #6c757d;
        font-size: 0.75rem;
    }
    
    .news-title {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}
    
    .news-excerpt {
    font-size: 0.9rem;
    color: #6c757d;
}
    
    .news-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.8rem;
    margin-top: 1rem;
}
    
    .read-more {
        font-size: 0.9rem;
        color: #0d6efd;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .read-more:hover {
        text-decoration: underline;
    }
    
    .reading-time {
        color: #adb5bd;
        font-size: 0.75rem;
    }
    
    .btn-outline {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        border-radius: 6px;
        border: 1px solid #dee2e6;
        background: transparent;
        color: #495057;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    
    .btn-outline:hover {
        border-color: #0d6efd;
        color: #0d6efd;
    }
</style>

<?= $this->endSection() ?>