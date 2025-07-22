<?= $this->extend('layouts/ciudadano') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Encabezado -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2 text-primary mb-1">
                        <i class="bi bi-pencil-square me-2"></i>Editar Reclamo #<?= esc($reclamo['id']) ?>
                    </h1>
                    <p class="text-muted">Actualiza los detalles de tu reclamo</p>
                </div>
                <a href="<?= site_url('ciudadano/mis-reclamos') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Volver
                </a>
            </div>

            <!-- Notificaciones -->
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

            <!-- Formulario principal -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <form action="<?= site_url('ciudadano/actualizar-reclamo/' . $reclamo['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <!-- ID del reclamo (solo lectura) -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">ID del Reclamo</label>
                            <input type="text" class="form-control" value="<?= esc($reclamo['id']) ?>" readonly>
                        </div>

                        <!-- Campo Categoría -->
                        <div class="mb-4">
                            <label for="categoria_id" class="form-label fw-semibold">
                                Categoría <span class="text-danger">*</span>
                            </label>
                            <select name="categoria_id" id="categoria_id" class="form-select" required>
                                <option value="">Selecciona una categoría</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?= esc($categoria['id']) ?>" <?= $reclamo['categoria_id'] == $categoria['id'] ? 'selected' : '' ?>>
                                        <?= esc($categoria['nombre_categoria']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Campo Descripción -->
                        <div class="mb-4">
                            <label for="descripcion" class="form-label fw-semibold">
                                Descripción <span class="text-danger">*</span>
                            </label>
                            <textarea name="descripcion" id="descripcion" class="form-control" 
                                      rows="6" placeholder="Describe tu reclamo..." 
                                      required><?= esc($reclamo['descripcion']) ?></textarea>
                        </div>

                        <!-- Estado (solo lectura) -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Estado Actual</label>
                            <div class="d-flex align-items-center">
                                <?php
                                    $badgeClass = [
                                        'pendiente' => 'bg-warning',
                                        'en_proceso' => 'bg-info',
                                        'solucionado' => 'bg-success',
                                        'resuelto' => 'bg-success'
                                    ][$reclamo['estado']] ?? 'bg-secondary';
                                ?>
                                <span class="badge <?= $badgeClass ?> me-2 fs-6">
                                    <?= esc(ucfirst($reclamo['estado'])) ?>
                                </span>
                                <input type="hidden" name="estado" value="<?= esc($reclamo['estado']) ?>">
                                
                                <?php if ($reclamo['estado'] == 'pendiente'): ?>
                                    <small class="text-muted">
                                        <i class="bi bi-info-circle me-1"></i> Puedes marcarlo como solucionado abajo
                                    </small>
                                <?php elseif ($reclamo['estado'] == 'en_proceso'): ?>
                                    <small class="text-muted">
                                        <i class="bi bi-hourglass-split me-1"></i> En proceso de revisión
                                    </small>
                                <?php else: ?>
                                    <small class="text-muted">
                                        <i class="bi bi-check-circle me-1"></i> Reclamo finalizado
                                    </small>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="<?= site_url('ciudadano/mis-reclamos') ?>" class="btn btn-outline-secondary me-md-2">
                                <i class="bi bi-x-circle me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sección de conversación/respuestas -->
            <div class="card border-info mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-chat-left-text me-2"></i> Conversación sobre este reclamo
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($todosComentarios)): ?>
                        <div class="chat-container" style="max-height: 300px; overflow-y: auto; margin-bottom: 20px;">
                            <?php foreach ($todosComentarios as $comentario): ?>
                                <div class="mb-3 <?= $comentario['rol_id'] == 1 ? 'text-end' : 'text-start' ?>">
                                    <div class="d-inline-block p-3 rounded-3 <?= $comentario['rol_id'] == 1 ? 'bg-primary text-white' : 'bg-light' ?>" style="max-width: 80%;">
                                        <div class="d-flex justify-content-between small mb-1">
                                            <span class="fw-semibold"><?= $comentario['rol_id'] == 1 ? 'Tú' : 'Administración' ?></span>
                                            <span><?= esc(date('d/m/Y H:i', strtotime($comentario['fecha']))) ?></span>
                                        </div>
                                        <div><?= nl2br(esc($comentario['comentario'])) ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info mb-0">
                            <i class="bi bi-info-circle me-2"></i> Aún no hay respuestas para este reclamo.
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($comentariosAdmin)): ?>
                        <form action="<?= site_url('ciudadano/responder-comentario/' . $reclamo['id']) ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="respuesta_ciudadano" class="form-label">Responder al administrador</label>
                                <textarea name="respuesta_ciudadano" id="respuesta_ciudadano" class="form-control" rows="3" required><?= old('respuesta_ciudadano') ?></textarea>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send me-1"></i> Enviar respuesta
                                </button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sección para marcar como solucionado -->
            <?php if (in_array($reclamo['estado'], ['pendiente', 'en_proceso'])): ?>
                <div class="card border-success bg-success bg-opacity-10 mb-4">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-check-circle-fill text-success fs-3 me-3"></i>
                            <h5 class="card-title text-success mb-0">¿Tu problema fue solucionado?</h5>
                        </div>
                        
                        <?php if ($reclamo['estado'] == 'pendiente'): ?>
                            <p class="card-text">Si consideras que tu reclamo ha sido resuelto satisfactoriamente, puedes marcarlo como solucionado.</p>
                        <?php else: ?>
                            <p class="card-text">Tu reclamo está en proceso, pero si ya fue resuelto, puedes marcarlo como solucionado.</p>
                        <?php endif; ?>
                        
                        <div class="alert alert-warning mt-3">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div>
                                    <strong>Importante:</strong> Esta acción no se puede deshacer. El reclamo quedará cerrado.
                                </div>
                            </div>
                        </div>
                        
                        <form action="<?= site_url('ciudadano/marcar-solucionado/' . $reclamo['id']) ?>" method="post" 
                              onsubmit="return confirm('¿Estás seguro de marcar este reclamo como solucionado? Esta acción no se puede deshacer.')">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-success mt-2">
                                <i class="bi bi-check-circle me-1"></i> Marcar como Solucionado
                            </button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Estilos adicionales -->
<style>
    textarea.form-control {
        min-height: 200px;
    }
    .card-title {
        font-size: 1.1rem;
    }
    .chat-container {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 15px;
    }
</style>

<?= $this->endSection() ?>