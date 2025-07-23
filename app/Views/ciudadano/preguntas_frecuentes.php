<?= $this->extend('layouts/ciudadano') ?>
<?= $this->section('content') ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h1 class="h4 mb-0">
                        <i class="bi bi-question-circle-fill text-primary me-2"></i>
                        Preguntas Frecuentes
                    </h1>
                </div>

                    <!-- Listado de preguntas -->
                    <div class="accordion" id="faqAccordion">
                        <!-- Pregunta 1 -->
                        <div class="accordion-item border-0 mb-3 shadow-sm">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                    <i class="bi bi-question-circle text-primary me-2"></i>
                                    ¿Cómo puedo realizar un nuevo reclamo?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Para realizar un nuevo reclamo:</p>
                                    <ol>
                                        <li>Inicie sesión en su cuenta</li>
                                        <li>Seleccione "Realizar Reclamo" en el menú principal</li>
                                        <li>Complete el formulario con los detalles del reclamo</li>
                                        <li>Adjunte documentos o evidencia si es necesario</li>
                                        <li>Haga clic en "Enviar Reclamo"</li>
                                    </ol>
                                    <p>Recibirá un número de seguimiento y confirmación por correo electrónico.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Pregunta 2 -->
                        <div class="accordion-item border-0 mb-3 shadow-sm">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                    <i class="bi bi-question-circle text-primary me-2"></i>
                                    ¿Cuánto tiempo tarda en resolverse un reclamo?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>El tiempo de resolución depende del tipo de reclamo:</p>
                                    <ul>
                                        <li><strong>Urgentes:</strong> 3-5 días hábiles (ej. problemas de seguridad)</li>
                                        <li><strong>Estándar:</strong> 10-15 días hábiles (ej. daños en vía pública)</li>
                                        <li><strong>Complejos:</strong> Hasta 30 días hábiles (ej. reclamos que requieren investigación)</li>
                                    </ul>
                                    <p>Puede verificar el estado en cualquier momento en la sección "Mis Reclamos".</p>
                                </div>
                            </div>
                        </div>

                        <!-- Pregunta 3 -->
                        <div class="accordion-item border-0 mb-3 shadow-sm">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                    <i class="bi bi-question-circle text-primary me-2"></i>
                                    ¿Qué documentos necesito para hacer un reclamo?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Los documentos requeridos varían según el tipo de reclamo:</p>
                                    <p><strong>Para todos los reclamos:</strong></p>
                                    <ul>
                                        <li>Identificación personal (cédula o pasaporte)</li>
                                        <li>Pruebas del problema (fotos, videos, documentos)</li>
                                    </ul>
                                    <p><strong>Adicionales según caso:</strong></p>
                                    <ul>
                                        <li>Facturas o recibos (para reclamos comerciales)</li>
                                        <li>Reportes policiales (para incidentes de seguridad)</li>
                                        <li>Documentos de propiedad (para problemas de vivienda)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Pregunta 4 -->
                        <div class="accordion-item border-0 mb-3 shadow-sm">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                    <i class="bi bi-question-circle text-primary me-2"></i>
                                    ¿Cómo puedo dar seguimiento a mi reclamo?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Tiene varias opciones para dar seguimiento:</p>
                                    <ol>
                                        <li><strong>En línea:</strong> Ingrese a "Mis Reclamos" para ver el estado actualizado</li>
                                        <li><strong>Por correo:</strong> Recibirá notificaciones en cada actualización importante</li>
                                        <li><strong>Por teléfono:</strong> Llame al 800-RECLAMO con su número de caso</li>
                                        <li><strong>Presencial:</strong> Visite nuestras oficinas con su identificación y número de caso</li>
                                    </ol>
                                    <p class="mt-3">El sistema muestra el historial completo de acciones realizadas sobre su reclamo.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Pregunta 5 -->
                        <div class="accordion-item border-0 mb-3 shadow-sm">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive">
                                    <i class="bi bi-question-circle text-primary me-2"></i>
                                    ¿Qué hago si no estoy satisfecho con la resolución?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    <p>Si no está satisfecho con la resolución de su reclamo:</p>
                                    <ol>
                                        <li><strong>Solicite revisión:</strong> En la sección de detalles del reclamo, seleccione "Solicitar Revisión"</li>
                                        <li><strong>Presente apelación:</strong> Tiene 10 días hábiles para presentar documentos adicionales que respalden su posición</li>
                                        <li><strong>Contacte supervisor:</strong> Puede solicitar que su caso sea elevado a un supervisor</li>
                                        <li><strong>Vía formal:</strong> Si persiste el desacuerdo, puede iniciar un proceso formal ante las instancias correspondientes</li>
                                    </ol>
                                    <p class="mt-3">Cada paso le será notificado por correo electrónico.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contacto adicional -->
                    <div class="alert alert-light mt-4">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-info-circle-fill text-primary fs-4 me-3"></i>
                            <div>
                                <h3 class="h6 mb-1">¿No encontró lo que buscaba?</h3>
                                <p class="mb-0">Contáctenos directamente a través de nuestro teléfono 6931-6518.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .accordion-button {
        font-weight: 500;
        padding: 1rem 1.5rem;
    }
    
    .accordion-button:not(.collapsed) {
        background-color: rgba(13, 110, 253, 0.05);
        color: #0d6efd;
    }
    
    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(13, 110, 253, 0.25);
    }
    
    .accordion-body {
        padding: 1.5rem;
    }
    
    .input-group-text {
        background-color: #f8f9fa;
    }
    
    .bg-light {
        background-color: #f8f9fa !important;
    }
    
    @media (max-width: 576px) {
        .accordion-button {
            font-size: 0.9rem;
            padding: 0.75rem 1rem;
        }
        
        .btn-outline-secondary {
            font-size: 0.8rem;
            padding: 0.25rem 0.5rem;
        }
    }
</style>

<?= $this->endSection() ?>