<?= $this->extend('layouts/ciudadano') ?>
<?= $this->section('content') ?>

<!-- Banner principal con efecto de gradiente mejorado -->
<section class="welcome-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="welcome-title animate__animated animate__fadeInDown">
                    Bienvenido al Portal Ciudadano
                </h1>
                <p class="welcome-subtitle animate__animated animate__fadeIn animate__delay-1s">
                    Registra tus reclamos y mira tus reportes en línea de manera sencilla.
                </p>
                <div class="welcome-actions animate__animated animate__fadeIn animate__delay-2s">
                    <a href="<?= site_url('ciudadano/nuevo-reclamo') ?>" class="btn btn-primary btn-lg">
                        <i class="bi bi-plus-circle me-2"></i> Crear nuevo reclamo
                    </a>
                    <a href="<?= site_url('ciudadano/mis-reclamos') ?>" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-list-check me-2"></i> Ver mis reclamos
                    </a>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block animate__animated animate__fadeIn animate__delay-1s">
                <img src="<?= base_url('assets/images/portal-ciudadano.png') ?>" alt="Ilustración portal ciudadano" class="welcome-image">
            </div>
        </div>
    </div>
</section>

<!-- Contenido principal -->
<main class="dashboard-container">
    <!-- Estadísticas dinámicas -->
    <section class="dashboard-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="bi bi-speedometer2"></i> Resumen de mis reclamos
                </h2>
            </div>
            
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
    </section>

    <!-- Reclamos recientes -->
    <section class="dashboard-section">
        <div class="container">
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
                    <?php 
                        $estadoClase = strtolower(str_replace(' ', '-', $reclamo['estado']));
                        $fechaFormateada = date('d M Y', strtotime($reclamo['fecha']));
                    ?>
                    <div class="complaint-card">
                        <div class="complaint-header">
                            <span class="complaint-id">#<?= esc($reclamo['id']) ?></span>
                            <span class="complaint-date"><?= esc($fechaFormateada) ?></span>
                        </div>
                        <h3 class="complaint-title"><?= esc($reclamo['descripcion']) ?></h3>
                        <div class="complaint-footer">
                            <span class="complaint-status <?= esc($estadoClase) ?>">
                                <?= esc(ucfirst($reclamo['estado'])) ?>
                            </span>
                            <a href="<?= site_url('ciudadano/ver-respuesta/' . $reclamo['id']) ?>" class="complaint-action">
                                <i class="bi bi-eye"></i> Ver detalles
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Acciones rápidas -->
    <section class="dashboard-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="bi bi-lightning-charge-fill"></i> Acciones rápidas
                </h2>
            </div>

            <div class="quick-actions-grid">
                <a href="<?= site_url('ciudadano/tramites') ?>" class="quick-action-card">
                    <div class="action-icon">
                        <i class="bi bi-file-earmark-text-fill"></i>
                    </div>
                    <div class="action-content">
                        <h3>Consultar trámites</h3>
                        <p>Revisa los trámites disponibles y sus requisitos</p>
                        <span class="action-link">
                            Ver trámites <i class="bi bi-arrow-right"></i>
                        </span>
                    </div>
                </a>

                <a href="<?= site_url('ciudadano/preguntas_frecuentes') ?>" class="quick-action-card">
                    <div class="action-icon">
                        <i class="bi bi-question-circle-fill"></i>
                    </div>
                    <div class="action-content">
                        <h3>Preguntas frecuentes</h3>
                        <p>Encuentra respuestas a las dudas más comunes</p>
                        <span class="action-link">
                            Ver ayuda <i class="bi bi-arrow-right"></i>
                        </span>
                    </div>
                </a>

                <a href="<?= site_url('ciudadano/perfil') ?>" class="quick-action-card">
                    <div class="action-icon">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="action-content">
                        <h3>Mi perfil</h3>
                        <p>Actualiza tus datos personales y preferencias</p>
                        <span class="action-link">
                            Editar perfil <i class="bi bi-arrow-right"></i>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Entidades accesibles -->

   <section class="dashboard-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="bi bi-building"></i> Otras entidades accesibles
                </h2>
            </div>

  <div class="logos-grid">
    <!-- Fila 1 -->
    <a href="https://www.innovacion.gob.pa/" target="_blank" class="logo-item">
      <img src="<?= base_url('img/aig-logo.png') ?>" alt="AIG">
    </a>
    <a href="https://www.acodeco.gob.pa/" target="_blank" class="logo-item">
      <img src="<?= base_url('img/acodeco-logo.png') ?>" alt="ACODECO">
    </a>
    <a href="https://www.antai.gob.pa/" target="_blank" class="logo-item">
      <img src="<?= base_url('img/anati-logo.png') ?>" alt="ANATI">
    </a>
    <a href="https://www.asep.gob.pa/" target="_blank" class="logo-item">
      <img src="<?= base_url('img/asep-logo.jpeg') ?>" alt="ASEP">
    </a>
    <a href="https://www.banconal.com.pa/" target="_blank" class="logo-item">
      <img src="<?= base_url('img/banconacional-logo.jpeg') ?>" alt="Banco Nacional de Panamá">
    </a>

    <!-- Fila 2 -->
    <a href="https://www.cajadeahorros.com.pa/" target="_blank" class="logo-item">
      <img src="<?= base_url('img/cajaahorro-logo.jpeg') ?>" alt="Caja de Ahorros">
    </a>
    <a href="https://www.pancanal.com/" target="_blank" class="logo-item">
      <img src="<?= base_url('img/canalpanama-logo.png') ?>" alt="Canal de Panamá">
    </a>
    <a href="https://www.idaan.gob.pa/" target="_blank" class="logo-item">
      <img src="<?= base_url('img/idaan-logo.png') ?>" alt="IDAAN">
    </a>
    <a href="https://www.ifarhu.gob.pa/" target="_blank" class="logo-item">
      <img src="<?= base_url('img/ifarhu-logo.png') ?>" alt="IFARHU">
    </a>
    <a href="https://www.defensoria.gob.pa/" target="_blank" class="logo-item">
      <img src="<?= base_url('img/defensoria-logo.png') ?>" alt="Defensoría del Pueblo">
    </a>
  </div>
</div>
</div>
</div>
</div>
</main>

<style>
    :root {
        --primary-color: #4361ee;
        --primary-dark: #3a56d4;
        --secondary-color: #3f37c9;
        --light-color: #f8f9fa;
        --dark-color: #212529;
        --success-color: #4cc9f0;
        --warning-color: #f8961e;
        --danger-color: #f72585;
        --gray-color: #6c757d;
        --light-gray: #e9ecef;
    }

    /* Estilos generales */
    body {
        font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        line-height: 1.6;
        color: #333;
    }

    .container {
        max-width: 1200px;
        padding: 0 20px;
    }

    /* Sección de bienvenida */
    /* Sección de bienvenida */
    .welcome-section {
        background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        color: white;
        padding: 30px 0;
        position: relative;
        overflow: hidden;
    }

    .welcome-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('<?= base_url('assets/images/pattern.png') ?>') repeat;
        opacity: 0.1;
        z-index: 0;
    }

    .welcome-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        position: relative;
    }

    .welcome-subtitle {
        font-size: 1.25rem;
        margin-bottom: 30px;
        opacity: 0.9;
        position: relative;
    }

    .welcome-actions {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        position: relative;
    }

    .welcome-image {
        max-width: 80%;
        height: auto;
        border-radius: 10px;
        box-shadow: 0 10px 10px rgba(0,0,0,0.2);
        transition: transform 0.3s ease;
    }

    .welcome-image:hover {
        transform: translateY(-5px);
    }

    /* Contenedor principal */
    .dashboard-container {
        padding: 40px 0;
        background-color: var(--light-color);
    }

    .dashboard-section {
        margin-bottom: 40px;
    }

    /* Contenedor principal */
    .dashboard-container {
        padding: 40px 0;
        background-color: var(--light-color);
    }

    .dashboard-section {
        margin-bottom: 40px;
    }

    /* Encabezados de sección */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--dark-color);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .view-all {
        display: flex;
        align-items: center;
        gap: 5px;
        color: var(--gray-color);
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .view-all:hover {
        color: var(--primary-color);
    }

    /* Estadísticas */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
    }

    .stat-card {
        padding: 25px;
        border-radius: 12px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background-color: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-size: 1.5rem;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 1rem;
        color: var(--gray-color);
    }

    /* Colores para estadísticas */
    .pending {
        border-left: 4px solid var(--danger-color);
    }
    .pending .stat-icon {
        background-color: rgba(247, 37, 133, 0.1);
        color: var(--danger-color);
    }
    
    .in-progress {
        border-left: 4px solid var(--warning-color);
    }
    .in-progress .stat-icon {
        background-color: rgba(248, 150, 30, 0.1);
        color: var(--warning-color);
    }
    
    .resolved {
        border-left: 4px solid var(--success-color);
    }
    .resolved .stat-icon {
        background-color: rgba(76, 201, 240, 0.1);
        color: var(--success-color);
    }

    /* Lista de reclamos */
    .complaints-list {
        display: grid;
        gap: 15px;
    }

    .complaint-card {
        background-color: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
    }

    .complaint-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .complaint-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .complaint-id {
        font-weight: 600;
        color: var(--primary-color);
    }

    .complaint-date {
        color: var(--gray-color);
        font-size: 0.9rem;
    }

    .complaint-title {
        font-size: 1.1rem;
        margin-bottom: 15px;
        color: var(--dark-color);
    }

    .complaint-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .complaint-status {
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .complaint-action {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        text-decoration: none;
        background-color: rgba(67, 97, 238, 0.1);
        color: var(--primary-color);
        transition: all 0.3s ease;
    }

    .complaint-action:hover {
        background-color: rgba(67, 97, 238, 0.2);
    }
    /* Colores por estado */
.complaint-status.pendiente {
    background-color: #fff3cd;
    color: #856404;
}

.complaint-status.en-proceso {
    background-color: #cce5ff;
    color: #004085;
}

.complaint-status.resuelto {
    background-color: #d4edda;
    color: #155724;
}

.complaint-status.rechazado {
    background-color: #f8d7da;
    color: #721c24;
}

/* Opcional: animación suave */
.complaint-status {
    transition: background-color 0.3s ease, color 0.3s ease;
}

.complaint-status.solucionado {
    background-color: #d1e7dd;
    color: #0f5132;
}
.complaint-status.en-proceso {
    background-color: #cce5ff;
    color: #004085;
}



    /* Acciones rápidas */
    .quick-actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .quick-action-card {
        background-color: white;
        border-radius: 12px;
        padding: 25px;
        display: flex;
        gap: 20px;
        align-items: center;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        border: 1px solid var(--light-gray);
    }

    .quick-action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        border-color: rgba(67, 97, 238, 0.2);
    }

    .action-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        flex-shrink: 0;
    }

    .quick-action-card:nth-child(1) .action-icon {
        background-color: var(--primary-color);
    }

    .quick-action-card:nth-child(2) .action-icon {
        background-color: #10b981;
    }

    .quick-action-card:nth-child(3) .action-icon {
        background-color: #f59e0b;
    }

    .action-content h3 {
        font-size: 1.1rem;
        margin-bottom: 5px;
        color: var(--dark-color);
    }

    .action-content p {
        font-size: 0.9rem;
        color: var(--gray-color);
        margin-bottom: 10px;
    }

    .action-link {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.9rem;
        color: var(--primary-color);
        transition: all 0.3s ease;
    }

    .quick-action-card:hover .action-link {
        transform: translateX(5px);
    }

    /* Entidades accesibles */
    /*Entidades accesibles */
     .logos-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr); /* Fuerza 5 columnas */
  gap: 2rem;
  justify-items: center;
  align-items: center;
  padding: 2rem;
  background-color: #fff;
  border-radius: 10px;
}

.logo-item img {
  max-width: 100px;
  height: auto;
  transition: transform 0.3s ease;
}

.logo-item:hover img {
  transform: scale(1.1);
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
}
</style>

<?= $this->endSection() ?>