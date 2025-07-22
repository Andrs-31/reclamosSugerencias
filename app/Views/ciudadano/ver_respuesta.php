<?= $this->extend('layouts/ciudadano') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Encabezado -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2 text-primary mb-1">
                        <i class="bi bi-chat-square-text me-2"></i>Detalles del Reclamo #<?= esc($reclamo['id']) ?>
                    </h1>
                    <p class="text-muted">Seguimiento completo de tu reclamo</p>
                </div>
                <a href="<?= site_url('ciudadano/mis-reclamos') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Volver
                </a>
            </div>

            <!-- Notificaciones -->
            <div class="notification-container">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="bi bi-check-circle me-2"></i>
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
                
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Tarjeta de información del reclamo -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h2 class="h5 mb-0">
                        <i class="bi bi-info-circle text-primary me-2"></i>
                        Información del Reclamo
                    </h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">Categoría</label>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-tag-fill text-primary me-2"></i>
                                <span><?= esc($reclamo['categoria_nombre'] ?? 'Sin categoría') ?></span>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">Estado</label>
                            <div class="d-flex align-items-center">
                                <?php
                                    $badgeClass = [
                                        'pendiente' => 'bg-warning',
                                        'en_proceso' => 'bg-info',
                                        'solucionado' => 'bg-success',
                                        'resuelto' => 'bg-success'
                                    ][$reclamo['estado']] ?? 'bg-secondary';
                                ?>
                                <span class="badge <?= $badgeClass ?> me-2">
                                    <i class="bi <?= 
                                        $reclamo['estado'] == 'pendiente' ? 'bi-hourglass' : 
                                        ($reclamo['estado'] == 'en_proceso' ? 'bi-arrow-repeat' : 'bi-check-circle')
                                    ?> me-1"></i>
                                    <?= esc(ucfirst(str_replace('_', ' ', $reclamo['estado']))) ?>
                                </span>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">Fecha de creación</label>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-calendar-event text-primary me-2"></i>
                                <span><?= esc(date('d/m/Y H:i', strtotime($reclamo['fecha']))) ?></span>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold text-muted">Última actualización</label>
                            <div class="d-flex align-items-center">
                                <i class="bi bi-arrow-clockwise text-primary me-2"></i>
                                <span><?= $reclamo['fecha_actualizacion'] ? esc(date('d/m/Y H:i', strtotime($reclamo['fecha_actualizacion']))) : 'Sin actualizar' ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold text-muted">Descripción</label>
                        <div class="bg-light p-3 rounded-2">
                            <?= nl2br(esc($reclamo['descripcion'])) ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historial de conversación -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom-0 py-3">
                    <h2 class="h5 mb-0">
                        <i class="bi bi-chat-left-text text-primary me-2"></i>
                        Historial de Conversación
                    </h2>
                </div>
                <div class="card-body">
                    <?php if (empty($todosComentarios)): ?>
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle me-2"></i> Aún no hay respuestas para este reclamo.
                        </div>
                    <?php else: ?>
                        <div class="timeline">
                            <?php foreach ($todosComentarios as $comentario): ?>
                                <div class="timeline-item <?= $comentario['rol_id'] == 1 ? 'timeline-item-user' : 'timeline-item-admin' ?>">
                                    <div class="timeline-icon">
                                        <?php if ($comentario['rol_id'] == 1): ?>
                                            <i class="bi bi-person-circle"></i>
                                        <?php else: ?>
                                            <i class="bi bi-shield-check"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-header">
                                            <span class="timeline-author">
                                                <?= $comentario['rol_id'] == 1 ? 'Tú' : 'Administración' ?>
                                            </span>
                                            <span class="timeline-date">
                                                <?= esc(date('d/m/Y H:i', strtotime($comentario['fecha']))) ?>
                                            </span>
                                        </div>
                                        <div class="timeline-message">
                                            <?= nl2br(esc($comentario['comentario'])) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Formulario de respuesta -->
            <?php if (!empty($comentariosAdmin) && in_array($reclamo['estado'], ['pendiente', 'en_proceso'])): ?>
                <div class="card border-primary shadow-sm mb-4">
                    <div class="card-header bg-primary text-white py-3">
                        <h2 class="h5 mb-0">
                            <i class="bi bi-reply-fill me-2"></i>
                            Responder al Administrador
                        </h2>
                    </div>
                    <div class="card-body">
                        <form action="<?= site_url('ciudadano/responder-comentario/' . $reclamo['id']) ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="respuesta_ciudadano" class="form-label">Tu respuesta</label>
                                <textarea name="respuesta_ciudadano" id="respuesta_ciudadano" class="form-control" 
                                          rows="4" placeholder="Escribe tu respuesta aquí..." 
                                          required><?= old('respuesta_ciudadano') ?></textarea>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-send me-1"></i> Enviar Respuesta
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Marcar como solucionado -->
            <?php if (in_array($reclamo['estado'], ['pendiente', 'en_proceso'])): ?>
                <div class="card border-success shadow-sm">
                    <div class="card-header bg-success text-white py-3">
                        <h2 class="h5 mb-0">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            ¿Problema resuelto?
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning mb-4">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div>
                                    <strong>Importante:</strong> Esta acción cerrará definitivamente el reclamo y no podrá ser revertida.
                                </div>
                            </div>
                        </div>
                        
                        <form action="<?= site_url('ciudadano/marcar-solucionado/' . $reclamo['id']) ?>" method="post" 
                              onsubmit="return confirm('¿Estás seguro de que tu reclamo ha sido solucionado completamente? Esta acción no se puede deshacer.')">
                            <?= csrf_field() ?>
                            <div class="text-end">
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="bi bi-check-circle me-1"></i> Marcar como Solucionado
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            <?php elseif (in_array($reclamo['estado'], ['resuelto', 'solucionado'])): ?>
                <div class="alert alert-success">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                        <div>
                            <h5 class="mb-1">Reclamo solucionado</h5>
                            <p class="mb-0">Este reclamo ha sido marcado como solucionado el <?= esc(date('d/m/Y', strtotime($reclamo['fecha_actualizacion']))) ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Estilos personalizados -->
<style>
    .notification-container {
        position: sticky;
        top: 1rem;
        z-index: 100;
    }
    
    .timeline {
        position: relative;
        padding-left: 50px;
    }
    
    .timeline:before {
        content: '';
        position: absolute;
        left: 20px;
        top: 0;
        bottom: 0;
        width: 2px;
        background-color: #e9ecef;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .timeline-icon {
        position: absolute;
        left: -50px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
    }
    
    .timeline-item-user .timeline-icon {
        background-color: #0d6efd;
    }
    
    .timeline-item-admin .timeline-icon {
        background-color: #6c757d;
    }
    
    .timeline-content {
        padding: 1rem;
        border-radius: 0.5rem;
        background-color: white;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .timeline-item-user .timeline-content {
        border-left: 3px solid #0d6efd;
    }
    
    .timeline-item-admin .timeline-content {
        border-left: 3px solid #6c757d;
    }
    
    .timeline-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }
    
    .timeline-author {
        font-weight: 600;
    }
    
    .timeline-item-user .timeline-author {
        color: #0d6efd;
    }
    
    .timeline-item-admin .timeline-author {
        color: #6c757d;
    }
    
    .timeline-date {
        color: #6c757d;
    }
    
    .timeline-message {
        line-height: 1.6;
    }
    
    @media (max-width: 768px) {
        .timeline {
            padding-left: 40px;
        }
        
        .timeline:before {
            left: 15px;
        }
        
        .timeline-icon {
            left: -40px;
            width: 30px;
            height: 30px;
            font-size: 1rem;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-scroll al final del timeline
    const timeline = document.querySelector('.timeline');
    if (timeline) {
        timeline.scrollTop = timeline.scrollHeight;
    }
    
    // Manejo de notificaciones
    (document.querySelectorAll('.alert .btn-close') || []).forEach((closeBtn) => {
        closeBtn.addEventListener('click', function() {
            this.closest('.alert').remove();
        });
    });
});
</script>

<?= $this->endSection() ?>