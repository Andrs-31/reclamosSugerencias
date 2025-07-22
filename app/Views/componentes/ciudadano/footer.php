<footer class="bg-secondary text-white py-5">
    <div class="container">
        <div class="row align-items-start">
            <!-- Columna 1: Logo y redes sociales -->
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <div class="footer-logo mb-3">
                    <img src="<?= base_url('assets/images/logo-reclamos.png') ?>" alt="Logo Plataforma de Reclamos" class="img-fluid" style="max-height: 70px;">
                </div>
                <p class="mb-3">Sistema para la gestión de reclamos y sugerencias ciudadanas.</p>
                <div class="social-icons">
                    <a href="https://wa.me/50769316518" class="text-white me-3" target="_blank" aria-label="WhatsApp">
                        <i class="bi bi-whatsapp fs-4"></i>
                    </a>
                    <a href="https://facebook.com/PlataformaReclamosPA" class="text-white me-3" target="_blank" aria-label="Facebook">
                        <i class="bi bi-facebook fs-4"></i>
                    </a>
                    <a href="https://instagram.com/PlataformaReclamosPA" class="text-white me-3" target="_blank" aria-label="Instagram">
                        <i class="bi bi-instagram fs-4"></i>
                    </a>
                    <a href="https://twitter.com/ReclamosPA" class="text-white" target="_blank" aria-label="Twitter">
                        <i class="bi bi-twitter fs-4"></i>
                    </a>
                </div>
            </div>
            
            <!-- Columna 2: Enlaces rápidos -->
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Enlaces rápidos</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="/reclamos/nuevo" class="text-white text-decoration-none d-flex align-items-center py-1">
                            <i class="bi bi-plus-circle me-2"></i> Realizar reclamo
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="/preguntas-frecuentes" class="text-white text-decoration-none d-flex align-items-center py-1">
                            <i class="bi bi-question-circle me-2"></i> Preguntas frecuentes
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="/noticias" class="text-white text-decoration-none d-flex align-items-center py-1">
                            <i class="bi bi-newspaper me-2"></i> Noticias
                        </a>
                    </li>
                    <li>
                        <a href="/contacto" class="text-white text-decoration-none d-flex align-items-center py-1">
                            <i class="bi bi-envelope me-2"></i> Contacto
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Columna 3: Contacto -->
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Contacto</h5>
                <ul class="list-unstyled">
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-envelope me-2 mt-1"></i>
                        <span>Reclamos.PA@gmail.com</span>
                    </li>
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-telephone me-2 mt-1"></i>
                        <span>+507 254-6511</span>
                    </li>
                    <li class="mb-3 d-flex align-items-start">
                        <i class="bi bi-whatsapp me-2 mt-1"></i>
                        <span>+507 6931-6518</span>
                    </li>
                    <li class="d-flex align-items-start">
                        <i class="bi bi-geo-alt me-2 mt-1"></i>
                        <span>Ciudad de Panamá, Panamá</span>
                    </li>
                </ul>
            </div>
            
            <!-- Columna 4: Horario de atención -->
            <div class="col-lg-3 col-md-6">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Horario de atención</h5>
                <ul class="list-unstyled">
                    <li class="mb-2 d-flex justify-content-between">
                        <span>Lunes a Viernes:</span>
                        <span>8:00 AM - 5:00 PM</span>
                    </li>
                    <li class="mb-2 d-flex justify-content-between">
                        <span>Sábados:</span>
                        <span>9:00 AM - 1:00 PM</span>
                    </li>
                    <li class="d-flex justify-content-between">
                        <span>Domingos:</span>
                        <span>Cerrado</span>
                    </li>
                </ul>
                <div class="mt-4">
                    <a href="/contacto" class="btn btn-outline-light btn-sm">
                        <i class="bi bi-headset me-1"></i> Soporte en línea
                    </a>
                </div>
            </div>
        </div>
        
        <hr class="my-4 border-light opacity-25">
        
        <div class="col-12 text-center">
    <p class="mb-0">&copy; <?= date('Y') ?> Plataforma de Reclamos. Todos los derechos reservados.</p>
</div>

    </div>
</footer>

<style>
    /* Estilos personalizados para el footer */
    footer {
        background: linear-gradient(135deg, #495057 0%, #343a40 100%);
    }
    
    .footer-logo img {
        transition: transform 0.3s ease;
    }
    
    .footer-logo:hover img {
        transform: scale(1.05);
    }
    
    .social-icons a {
        display: inline-block;
        transition: all 0.3s ease;
        margin-right: 15px;
    }
    
    .social-icons a:last-child {
        margin-right: 0;
    }
    
    .social-icons a:hover {
        transform: translateY(-3px);
        opacity: 0.8;
    }
    
    .list-unstyled a {
        transition: all 0.2s ease;
        border-radius: 4px;
        padding: 4px 0;
    }
    
    .list-unstyled a:hover {
        color: #adb5bd !important;
        padding-left: 5px;
    }
    
    .border-bottom {
        border-bottom: 2px solid rgba(255, 255, 255, 0.1) !important;
    }
    
    .btn-outline-light {
        transition: all 0.3s ease;
        border-width: 2px;
    }
    
    .btn-outline-light:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }
    
    @media (max-width: 768px) {
        .footer-logo {
            text-align: center;
        }
        
        .social-icons {
            justify-content: center;
        }
    }
</style>