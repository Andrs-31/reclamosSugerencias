<?= $this->extend('layouts/ciudadano') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Encabezado -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2 text-primary mb-1">
                        <i class="bi bi-megaphone me-2"></i>Nuevo Reclamo
                    </h1>
                    <p class="text-muted">Completa el formulario para registrar tu reclamo o sugerencia</p>
                </div>
                <a href="<?= site_url('ciudadano/dashboard') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Volver
                </a>
            </div>

            <!-- Flash messages -->
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

            <div class="row gy-4">
                <!-- Formulario -->
                <div class="col-lg-7">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-body p-4">
                            <form action="<?= site_url('ciudadano/guardar-reclamo') ?>" method="post">
                                <?= csrf_field() ?>
                                
                                <!-- Categoría -->
                                <div class="mb-4">
                                    <label for="categoria_id" class="form-label fw-semibold">
                                        Categoría <span class="text-danger">*</span>
                                    </label>
                                    <select name="categoria_id" id="categoria_id" class="form-select form-select-lg" required>
                                        <option value="" disabled selected>Selecciona una categoría</option>
                                        <?php foreach ($categorias as $categoria): ?>
                                            <option value="<?= esc($categoria['id']) ?>" <?= old('categoria_id') == $categoria['id'] ? 'selected' : '' ?>>
                                                <?= esc($categoria['nombre_categoria']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="form-text text-muted">Selecciona el tipo de reclamo o sugerencia</small>
                                </div>

                                <!-- Descripción -->
                                <div class="mb-4">
                                    <label for="descripcion" class="form-label fw-semibold">
                                        Descripción detallada <span class="text-danger">*</span>
                                    </label>
                                    <textarea name="descripcion" id="descripcion" class="form-control" rows="6" placeholder="Describe tu reclamo con todos los detalles..." required><?= old('descripcion') ?></textarea>
                                    <small class="form-text text-muted">
                                        <i class="bi bi-info-circle me-1"></i> Incluye ubicación, fecha y detalles relevantes
                                    </small>
                                </div>

                                <!-- Botones -->
                                <div class="d-flex justify-content-end mt-4 gap-2">
                                    <button type="reset" class="btn btn-outline-secondary">
                                        <i class="bi bi-eraser me-1"></i> Limpiar
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-send-check me-1"></i> Enviar Reclamo
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Ilustración y consejos -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body text-center p-3">
                            <img src="<?= base_url('assets/images/crear-reclamo.png') ?>" alt="Ilustración de reclamo ciudadano" class="img-fluid rounded mb-3" style="max-height: 260px;">
                        </div>
                    </div>

                    <div class="card border-0 bg-light shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="text-primary mb-3"><i class="bi bi-lightbulb me-2"></i>Consejos para un buen reclamo:</h5>
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Sé claro y específico</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Incluye ubicación exacta</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i> Proporciona fechas relevantes</li>
                                <li><i class="bi bi-check-circle-fill text-success me-2"></i> Mantén un tono respetuoso</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información adicional para móviles -->
            <div class="d-lg-none mt-4">
                <div class="alert alert-info d-flex align-items-center">
                    <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                    <div>
                        <h5 class="alert-heading mb-1">¿Necesitas ayuda?</h5>
                        <p class="mb-0">Consulta nuestras <a href="<?= site_url('preguntas-frecuentes') ?>" class="alert-link">preguntas frecuentes</a>.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estilos personalizados -->
<style>
    textarea.form-control {
        min-height: 180px;
    }
    .form-select-lg, .form-control {
        padding: 0.75rem 1rem;
    }
    .card {
        border-radius: 14px;
    }
</style>

<?= $this->endSection() ?>
