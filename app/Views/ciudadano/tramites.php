<?= $this->extend('layouts/ciudadano') ?>
<?= $this->section('content') ?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Encabezado -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h2 text-primary mb-1">
                        <i class="bi bi-file-earmark-text me-2"></i>Información sobre Trámites
                    </h1>
                    <p class="text-muted">Enlace a los sistemas de trámites oficiales</p>
                </div>
                <a href="<?= site_url('ciudadano/dashboard') ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Volver al inicio
                </a>
            </div>

            <!-- Tarjeta informativa -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <i class="bi bi-info-circle-fill text-primary fs-3 me-3"></i>
                        <h2 class="h4 mb-0">Sistema especializado en reclamos</h2>
                    </div>
                    
                    <p>Nuestra plataforma está dedicada exclusivamente a la gestión de <strong>reclamos y sugerencias</strong> ciudadanas.</p>
                    
                    <div class="alert alert-info mt-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-lightbulb me-3 fs-4"></i>
                            <div>
                                <p class="mb-0">Para realizar trámites en línea, te recomendamos visitar los siguientes portales oficiales:</p>
                            </div>
                        </div>
                    </div>

                    <!-- Lista de trámites -->
                    <div class="list-group mt-4">
                        <a href="https://www.panamatramita.gob.pa" class="list-group-item list-group-item-action" target="_blank">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-box-arrow-up-right me-3 text-primary"></i>
                                <div>
                                    <h5 class="mb-1">Panamá Tramita</h5>
                                    <p class="mb-0 small text-muted">Portal oficial de trámites del gobierno</p>
                                </div>
                            </div>
                        </a>
                        
                        <a href="https://www.mingob.gob.pa" class="list-group-item list-group-item-action" target="_blank">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-box-arrow-up-right me-3 text-primary"></i>
                                <div>
                                    <h5 class="mb-1">Ministerio de Gobierno</h5>
                                    <p class="mb-0 small text-muted">Trámites de documentación personal</p>
                                </div>
                            </div>
                        </a>
                        
                        <a href="https://www.mitradel.gob.pa" class="list-group-item list-group-item-action" target="_blank">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-box-arrow-up-right me-3 text-primary"></i>
                                <div>
                                    <h5 class="mb-1">MITRADEL</h5>
                                    <p class="mb-0 small text-muted">Trámites laborales y migratorios</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sección de ayuda -->
            <div class="card border-primary bg-primary bg-opacity-10">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-question-circle-fill text-primary fs-3 me-3"></i>
                        <div>
                            <h3 class="h5 mb-1">¿Necesitas ayuda con un reclamo?</h3>
                            <p class="mb-0">Si tienes dudas sobre cómo realizar un reclamo o sugerencia, visita nuestra sección de ayuda.</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="<?= site_url('ciudadano/preguntas_frecuentes') ?>" class="btn btn-primary">
                            <i class="bi bi-question-circle me-1"></i> Ver preguntas frecuentes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .list-group-item {
        transition: all 0.2s ease;
        margin-bottom: 8px;
        border-radius: 8px !important;
        border-left: 3px solid transparent;
    }
    
    .list-group-item:hover {
        transform: translateX(5px);
        border-left: 3px solid #0d6efd;
    }
    
    .list-group-item h5 {
        transition: color 0.2s ease;
    }
    
    .list-group-item:hover h5 {
        color: #0d6efd;
    }
</style>

<?= $this->endSection() ?>