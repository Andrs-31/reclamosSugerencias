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
                                <img src="<?= base_url('assets/images/avatar-user.png') ?>" alt="Avatar" class="rounded-circle mb-3" width="120" height="120">
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
                                <li class="nav-item">
                                    <a class="nav-link" href="#notificaciones" data-bs-toggle="tab">
                                        <i class="bi bi-bell me-2"></i> Notificaciones
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#preferencias" data-bs-toggle="tab">
                                        <i class="bi bi-gear me-2"></i> Preferencias
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
                                            <div class="col-md-6">
                                                <label for="apellido" class="form-label">Apellido</label>
                                                <input type="text" class="form-control" id="apellido" name="apellido" 
                                                       value="<?= esc($usuario['apellido'] ?? '') ?>" required>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Correo electrónico</label>
                                            <input type="email" class="form-control" id="email" name="email" 
                                                   value="<?= esc($usuario['email'] ?? '') ?>" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="telefono" class="form-label">Teléfono</label>
                                            <input type="tel" class="form-control" id="telefono" name="telefono" 
                                                   value="<?= esc($usuario['telefono'] ?? '') ?>">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="direccion" class="form-label">Dirección</label>
                                            <textarea class="form-control" id="direccion" name="direccion" 
                                                      rows="2"><?= esc($usuario['direccion'] ?? '') ?></textarea>
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
                        </div>
                        
                        <!-- Pestaña Notificaciones -->
                        <div class="tab-pane fade" id="notificaciones">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-bottom-0 py-3">
                                    <h2 class="h5 mb-0">
                                        <i class="bi bi-bell text-primary me-2"></i>
                                        Preferencias de Notificación
                                    </h2>
                                </div>
                                <div class="card-body">
                                    <form action="<?= site_url('ciudadano/actualizar-notificaciones') ?>" method="post">
                                        <?= csrf_field() ?>
                                        
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="notificaciones_email" name="notificaciones_email" 
                                                       <?= ($usuario['notificaciones_email'] ?? 1) ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="notificaciones_email">Recibir notificaciones por correo</label>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="notificaciones_sms" name="notificaciones_sms" 
                                                       <?= ($usuario['notificaciones_sms'] ?? 0) ? 'checked' : '' ?>>
                                                <label class="form-check-label" for="notificaciones_sms">Recibir notificaciones por SMS</label>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label class="form-label">Frecuencia de notificaciones</label>
                                            <select class="form-select" name="frecuencia_notificaciones">
                                                <option value="inmediato" <?= ($usuario['frecuencia_notificaciones'] ?? '') == 'inmediato' ? 'selected' : '' ?>>Inmediato</option>
                                                <option value="diario" <?= ($usuario['frecuencia_notificaciones'] ?? '') == 'diario' ? 'selected' : '' ?>>Resumen diario</option>
                                                <option value="semanal" <?= ($usuario['frecuencia_notificaciones'] ?? '') == 'semanal' ? 'selected' : '' ?>>Resumen semanal</option>
                                            </select>
                                        </div>
                                        
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-save me-1"></i> Guardar preferencias
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Pestaña Preferencias -->
                        <div class="tab-pane fade" id="preferencias">
                            <div class="card border-0 shadow-sm">
                                <div class="card-header bg-white border-bottom-0 py-3">
                                    <h2 class="h5 mb-0">
                                        <i class="bi bi-gear text-primary me-2"></i>
                                        Configuración del Sistema
                                    </h2>
                                </div>
                                <div class="card-body">
                                    <form action="<?= site_url('ciudadano/actualizar-preferencias') ?>" method="post">
                                        <?= csrf_field() ?>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Idioma preferido</label>
                                            <select class="form-select" name="idioma">
                                                <option value="es" <?= ($usuario['idioma'] ?? '') == 'es' ? 'selected' : '' ?>>Español</option>
                                                <option value="en" <?= ($usuario['idioma'] ?? '') == 'en' ? 'selected' : '' ?>>Inglés</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">Tema de interfaz</label>
                                            <select class="form-select" name="tema">
                                                <option value="claro" <?= ($usuario['tema'] ?? '') == 'claro' ? 'selected' : '' ?>>Claro</option>
                                                <option value="oscuro" <?= ($usuario['tema'] ?? '') == 'oscuro' ? 'selected' : '' ?>>Oscuro</option>
                                                <option value="sistema" <?= ($usuario['tema'] ?? '') == 'sistema' ? 'selected' : '' ?>>Usar configuración del sistema</option>
                                            </select>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label class="form-label">Zona horaria</label>
                                            <select class="form-select" name="zona_horaria">
                                                <option value="America/Panama" <?= ($usuario['zona_horaria'] ?? '') == 'America/Panama' ? 'selected' : '' ?>>Panamá (UTC-5)</option>
                                                <option value="America/Mexico_City" <?= ($usuario['zona_horaria'] ?? '') == 'America/Mexico_City' ? 'selected' : '' ?>>Ciudad de México (UTC-6)</option>
                                                <option value="America/Bogota" <?= ($usuario['zona_horaria'] ?? '') == 'America/Bogota' ? 'selected' : '' ?>>Bogotá (UTC-5)</option>
                                            </select>
                                        </div>
                                        
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-save me-1"></i> Guardar configuración
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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


<?= $this->endSection() ?>