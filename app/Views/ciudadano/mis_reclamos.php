<?= $this->extend('layouts/ciudadano') ?>
<?= $this->section('content') ?>

<div class="container mt-4">
    <!-- Encabezado mejorado -->
    <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
        <div>
            <h1 class="h2 mb-1 text-primary"><i class="bi bi-megaphone me-2"></i>Mis Reclamos</h1>
            <p class="text-muted mb-0">Gestiona y da seguimiento a tus reportes ciudadanos</p>
        </div>
        <a href="<?= site_url('ciudadano/nuevo-reclamo') ?>" class="btn btn-primary btn-lg shadow-sm">
            <i class="bi bi-plus-circle-fill me-2"></i>Nuevo Reclamo
        </a>
    </div>

    <!-- Notificaciones mejoradas -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show d-flex align-items-center shadow-sm">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div><?= session()->getFlashdata('success') ?></div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center shadow-sm">
            <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
            <div><?= session()->getFlashdata('error') ?></div>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Tarjeta contenedora -->
<div class="card border-0 shadow-sm mb-5 pb-4">
    <div class="card-body p-0">
        <?php if (empty($reclamos)): ?>
            <div class="text-center py-5">
                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                <h4 class="mt-3 text-muted">No tienes reclamos registrados</h4>
                <p class="text-muted mb-4">Comienza creando tu primer reclamo</p>
                <a href="<?= site_url('ciudadano/nuevo-reclamo') ?>" class="btn btn-primary px-4">
                    <i class="bi bi-plus-circle me-2"></i>Crear primer reclamo
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Categoría</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Actualización</th>
                            <th>Comentarios</th>
                            <th class="pe-4 text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reclamos as $reclamo): ?>
                            <tr data-id="<?= $reclamo['id'] ?>" class="align-middle">
                                <td class="ps-4 fw-semibold text-muted">#<?= esc($reclamo['id']) ?></td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <i class="bi bi-tag-fill me-1 text-primary"></i>
                                        <?= esc($reclamo['categoria_nombre'] ?? 'General') ?>
                                    </span>
                                </td>
                                <td class="text-truncate" style="max-width: 200px;" title="<?= esc($reclamo['descripcion']) ?>">
                                    <?= esc(character_limiter($reclamo['descripcion'], 50)) ?>
                                </td>
                                <td>
                                    <span class="badge rounded-pill bg-<?= 
                                        $reclamo['estado'] == 'pendiente' ? 'warning' : 
                                        (in_array($reclamo['estado'], ['resuelto', 'solucionado']) ? 'success' : 'danger')
                                    ?>">
                                        <i class="bi bi-<?= 
                                            $reclamo['estado'] == 'pendiente' ? 'clock' : 
                                            (in_array($reclamo['estado'], ['resuelto', 'solucionado']) ? 'check-circle' : 'exclamation-triangle')
                                        ?> me-1"></i>
                                        <?= esc(ucfirst($reclamo['estado'])) ?>
                                    </span>
                                </td>
                                <td class="small text-muted">
                                    <?= esc(date('d/m/Y', strtotime($reclamo['fecha']))) ?>
                                    <div class="text-muted" style="font-size: 0.75rem;">
                                        <?= esc(date('H:i', strtotime($reclamo['fecha']))) ?>
                                    </div>
                                </td>
                                <td class="small text-muted">
                                    <?php if ($reclamo['fecha_actualizacion']): ?>
                                        <?= esc(date('d/m/Y', strtotime($reclamo['fecha_actualizacion']))) ?>
                                        <div class="text-muted" style="font-size: 0.75rem;">
                                            <?= esc(date('H:i', strtotime($reclamo['fecha_actualizacion']))) ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Respuesta -->
                                <td>
                                    <?php if (isset($reclamo['tiene_respuesta']) && $reclamo['tiene_respuesta']): ?>
                                        <a href="<?= site_url('ciudadano/ver-respuesta/' . $reclamo['id']) ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-chat-square-text me-1"></i> Ver Respuesta
                                        </a>
                                    <?php else: ?>
                                        <span class="btn btn-sm btn-outline-secondary" disabled>
                                            <i class="bi bi-hourglass-split"></i> Sin Respuesta
                                        </span>
                                    <?php endif; ?>
                                </td>

                                <!-- Acciones -->
                                <td class="pe-4 text-end">
                                    <div class="btn-group btn-group-sm shadow-sm">
                                        <?php if (empty($reclamo['tiene_respuesta'])): ?>
        
                                            <!-- Eliminar activo -->
                                            <button class="btn btn-outline-danger" onclick="confirmarEliminacion(<?= $reclamo['id'] ?>)" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        <?php else: ?>
                                            <!-- Botones deshabilitados -->
                                            <button class="btn btn-outline-secondary" disabled title="No editable">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <button class="btn btn-outline-secondary" disabled title="No eliminable">
                                                <i class="bi bi-lock"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>


<script>
function confirmarEliminacion(id) {
    Swal.fire({
        title: '¿Eliminar reclamo?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`<?= site_url('ciudadano/eliminar-reclamo/') ?>${id}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: '¡Eliminado!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        document.querySelector(`tr[data-id="${id}"]`).remove();
                        
                        if (!document.querySelector('tbody tr')) {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => Swal.fire('Error', 'Error al eliminar el reclamo', 'error'));
        }
    });
}
</script>

<?= $this->endSection() ?>