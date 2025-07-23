<?= $this->extend('layouts/ciudadano') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Encabezado -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2 text-primary mb-1">
                        <i class="bi bi-person-gear me-2"></i>Configuración de Perfil
                    </h1>
                    <p class="text-muted">Administra tu información personal y preferencias</p>
                </div>
                <a href="<?= site_url('ciudadano/dashboard') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Volver al inicio
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

            <div class="row">
                <!-- Columna izquierda - Menú -->
                <div class="col-md-4 mb-4 mb-md-0">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <h5 class="mb-1"><?= esc($usuario['nombre'] ?? 'Usuario') ?></h5>
                                <p class="text-muted small"><?= esc($usuario['email'] ?? 'correo@ejemplo.com') ?></p>
                            </div>
                            
                            <ul class="nav flex-column nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#datos-personales" data-bs-toggle="tab">
                                        <i class="bi bi-person-vcard me-2"></i> Datos personales
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#seguridad" data-bs-toggle="tab">
                                        <i class="bi bi-shield-lock me-2"></i> Seguridad
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <!-- Columna derecha - Contenido -->
                <div class="col-md-8">
                    <div class="tab-content">
                        <!-- Pestaña Datos Personales -->
                        <div class="tab-pane fade show active" id="datos-personales">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-bottom-0 py-3">
                                    <h2 class="h5 mb-0">
                                        <i class="bi bi-person-vcard text-primary me-2"></i>
                                        Información Personal
                                    </h2>
                                </div>
                                <div class="card-body">
                                    <form action="<?= site_url('ciudadano/actualizar-perfil') ?>" method="post">
                                        <?= csrf_field() ?>
                                        
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="nombre" class="form-label">Nombre</label>
                                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                                       value="<?= esc($usuario['nombre'] ?? '') ?>" required>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="email" class="form-label">Correo electrónico</label>
                                            <input type="email" class="form-control" id="email" name="email" 
                                                   value="<?= esc($usuario['email'] ?? '') ?>" required>
                                        </div>
                                        
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-save me-1"></i> Guardar cambios
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pestaña Seguridad -->
                        <div class="tab-pane fade" id="seguridad">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-bottom-0 py-3">
                                    <h2 class="h5 mb-0">
                                        <i class="bi bi-shield-lock text-primary me-2"></i>
                                        Configuración de Seguridad
                                    </h2>
                                </div>
                                <div class="card-body">
                                    <form action="<?= site_url('ciudadano/cambiar-password') ?>" method="post">
                                        <?= csrf_field() ?>
                                        
                                        <div class="mb-3">
                                            <label for="password_actual" class="form-label">Contraseña actual</label>
                                            <input type="password" class="form-control" id="password_actual" name="password_actual" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="nuevo_password" class="form-label">Nueva contraseña</label>
                                            <input type="password" class="form-control" id="nuevo_password" name="nuevo_password" required>
                                            <div class="form-text">Mínimo 8 caracteres, incluyendo mayúsculas, minúsculas y números</div>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="confirmar_password" class="form-label">Confirmar nueva contraseña</label>
                                            <input type="password" class="form-control" id="confirmar_password" name="confirmar_password" required>
                                        </div>
                                        
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-key me-1"></i> Cambiar contraseña
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> <!-- fin pestaña seguridad -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Estilos adicionales -->
<style>
    .nav-pills .nav-link {
        border-radius: 8px;
        margin-bottom: 10px;
        padding: 14px 20px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .nav-pills .nav-link.active {
        background-color: #0d6efd;
        color: white;
    }

    .nav-pills .nav-link:not(.active) {
        color: #495057;
    }

    .nav-pills .nav-link:not(.active):hover {
        background-color: #f1f1f1;
    }

    .form-control,
    .form-select,
    textarea {
        font-size: 1.1rem;
        padding: 14px 16px;
        min-height: 50px;
    }

    label.form-label {
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 6px;
    }

    .card-body {
        padding: 2rem;
    }

    .card-header h2 {
        font-size: 1.25rem;
    }

    .btn {
        font-size: 1.05rem;
        padding: 12px 24px;
    }

    @media (min-width: 992px) {
        .col-lg-8 {
            flex: 0 0 90%;
            max-width: 90%;
        }
    }

    @media (max-width: 768px) {
        .nav-pills {
            flex-direction: row !important;
            overflow-x: auto;
            white-space: nowrap;
            padding-bottom: 8px;
        }

        .nav-pills .nav-link {
            display: inline-block;
            margin-right: 8px;
            margin-bottom: 0;
        }
    }
</style>

<!-- Bootstrap JS para que las pestañas funcionen -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?= $this->endSection() ?>
