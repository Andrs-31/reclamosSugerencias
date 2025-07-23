<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistema de Reclamos' ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Estilos personalizados -->
    <link href="<?= base_url('assets/css/styles.css') ?>" rel="stylesheet">

    <?= $this->renderSection('head') ?>
</head>
<body class="bg-light">

<!-- NAVBAR MEJORADO -->
<nav class="navbar navbar-expand-lg navbar-dark bg-secondary shadow-sm">
    <div class="container-fluid">
        <!-- Logo y marca con efecto hover -->
        <span class="navbar-brand">
    <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo Reclamos.PA" height="40" class="me-2 logo-img">
    <span class="fw-bold"></span>
</span>

        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <!-- Menú principal -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() === 'dashboard' ? 'active fw-bold' : '' ?>" href="<?= base_url('ciudadano/dashboard') ?>">
                        <i class="bi bi-house-door me-1"></i> Inicio
                    </a>
                </li>
                
                <!-- Menú desplegable de Reclamos -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarReclamos" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-chat-square-text me-1"></i> Reclamos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarReclamos">
                        <li>
                            <a class="dropdown-item" href="<?= site_url('ciudadano/nuevo-reclamo') ?>">
                                <i class="bi bi-plus-circle me-2"></i> Realizar Reclamo
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= site_url('ciudadano/mis-reclamos') ?>">
                                <i class="bi bi-list-check me-2"></i> Mis Reclamos
                            </a>
                        </li>
                    </ul>
                </li>
                
                <!-- Menú desplegable de otros -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarOtros" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-three-dots-vertical me-1"></i> Otros
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarOtros">
                        <li><a class="dropdown-item" href="<?= base_url('ciudadano/tramites') ?>">
                            <i class="bi bi-file-earmark-text me-2"></i> Trámites
                        </a></li>
                        <li><a class="dropdown-item" href="<?= base_url('ciudadano/preguntas_frecuentes') ?>">
                            <i class="bi bi-question-circle me-2"></i> Ayuda
                        </a></li>
                        <li>
            <a class="dropdown-item" href="http://localhost/webConsumo/Reclamos_api.html" target="_blank" rel="noopener noreferrer">
                <i class="bi bi-bar-chart-fill me-2"></i> Reportes Públicos
            </a>
        </li>
    </ul>
</li>
                    </ul>
                </li>
            </ul>
            
            <!-- Menú usuario -->
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarCuenta" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-1"></i> Mi Cuenta
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarCuenta">
                        <li><a class="dropdown-item" href="<?= site_url('ciudadano/perfil') ?>"
>
                            <i class="bi bi-person me-2"></i> Mi Perfil
                        <li><a class="dropdown-item text-danger" href="<?= site_url('logout') ?>">
    <i class="bi bi-box-arrow-right me-2"></i> Cerrar sesión
</a></li>

                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    /* Estilo para el navbar */
    .navbar {
        background: linear-gradient(135deg, #495057 0%, #343a40 100%) !important;
        padding: 0.5rem 1rem;
    }
    
    /* Efecto hover para el logo */
    .logo-img {
        transition: transform 0.3s ease;
    }
    
    .navbar-brand:hover .logo-img {
        transform: scale(1.05);
    }
    
    /* Estilo para los enlaces del navbar */
    .nav-link {
        transition: all 0.2s ease;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        margin: 0 2px;
    }
    
    .nav-link:hover {
        background-color: rgba(255, 255, 255, 0.1);
        transform: translateY(-1px);
    }
    
    .nav-link.active {
        background-color: rgba(255, 255, 255, 0.15);
    }
    
    /* Estilo para los dropdowns */
    .dropdown-menu {
        border: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        border-radius: 8px;
        padding: 0.5rem;
    }
    
    .dropdown-item {
        transition: all 0.2s ease;
        border-radius: 4px;
        padding: 0.5rem 1rem;
        margin: 2px 0;
    }
    
    .dropdown-item:hover {
        background-color: #f8f9fa;
        padding-left: 1.2rem;
    }
    
    .dropdown-divider {
        margin: 0.3rem 0;
    }
    
    /* Estilo para el botón de toggle en móviles */
    .navbar-toggler {
        border: none;
        padding: 0.5rem;
    }
    
    .navbar-toggler:focus {
        box-shadow: none;
    }
    
    /* Efecto hover para los iconos */
    .bi {
        transition: transform 0.2s ease;
    }
    
    .nav-link:hover .bi,
    .dropdown-item:hover .bi {
        transform: scale(1.1);
    }
    
    /* Responsive adjustments */
    @media (max-width: 992px) {
        .navbar-collapse {
            padding: 1rem 0;
        }
        
        .nav-item {
            margin: 2px 0;
        }
        
        .dropdown-menu {
            margin-left: 1rem;
            box-shadow: none;
        }
    }
</style>

<!-- CONTENIDO -->
<main class="container-fluid px-0">
    <?= $this->renderSection('content') ?>
</main>

<!-- FOOTER MEJORADO -->
<footer class="bg-secondary text-white py-5">
    <div class="container">
        <div class="row align-items-start">
            <!-- Columna 1: Logo y redes sociales -->
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <div class="footer-logo mb-3">
                    <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo Plataforma de Reclamos" class="img-fluid" style="max-height: 70px;">
                </div>
                <p class="mb-3">Sistema para la gestión de reclamos y sugerencias ciudadanas.</p>
                <div class="social-icons">
                    <a href="https://wa.me/50769316518" class="text-white me-3" target="_blank" aria-label="WhatsApp">
                        <i class="bi bi-whatsapp fs-4"></i>
                    </a>
                    <a href="https://facebook.com" class="text-white me-3" target="_blank" aria-label="Facebook">
                        <i class="bi bi-facebook fs-4"></i>
                    </a>
                    <a href="https://instagram.com" class="text-white me-3" target="_blank" aria-label="Instagram">
                        <i class="bi bi-instagram fs-4"></i>
                    </a>
                    <a href="https://twitter.com" class="text-white" target="_blank" aria-label="Twitter">
                        <i class="bi bi-twitter fs-4"></i>
                    </a>
                </div>
            </div>
            
            <!-- Columna 2: Enlaces rápidos -->
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="fw-bold mb-3 border-bottom pb-2">Enlaces rápidos</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="<?= site_url('ciudadano/nuevo-reclamo') ?>"
 class="text-white text-decoration-none d-flex align-items-center py-1">
                            <i class="bi bi-plus-circle me-2"></i> Realizar reclamo
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="<?= site_url('ciudadano/preguntas_frecuentes') ?>"
 class="text-white text-decoration-none d-flex align-items-center py-1">
                            <i class="bi bi-question-circle me-2"></i> Preguntas frecuentes
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-white text-decoration-none d-flex align-items-center py-1" data-bs-toggle="modal" data-bs-target="#modalContacto">
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
                        <span>Reclamos.Sugerencias@gmail.com</span>
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
                    <a href="#" class="btn btn-outline-light btn-sm" data-bs-toggle="modal" data-bs-target="#modalSoporte">
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

    <!-- Modal Soporte Virtual Corregido -->
<div class="modal fade" id="modalSoporte" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-dark text-white">
        <h5 class="modal-title"><i class="bi bi-robot me-2"></i>Soporte en línea</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <!-- Historial del chat -->
        <div id="chatHistory" class="mb-3 p-3 bg-light rounded" style="height: 200px; overflow-y: auto;">
          <div class="bot-message text-start">
            <small class="text-muted">Soporte:</small>
            <div class="bg-secondary text-white p-2 rounded d-inline-block">Hola 👋 ¿En qué puedo ayudarte hoy?</div>
          </div>
        </div>
        
        <!-- Opciones rápidas -->
        <div class="d-flex flex-wrap gap-2 mb-3">
          <button class="btn btn-sm btn-outline-primary quick-option">Estado de reclamo</button>
          <button class="btn btn-sm btn-outline-success quick-option">Enviar sugerencia</button>
          <button class="btn btn-sm btn-outline-dark quick-option">Hablar con agente</button>
        </div>
        
        <!-- Campo de entrada -->
        <div class="input-group">
          <input type="text" id="userMessage" class="form-control" placeholder="Escribe tu mensaje...">
          <button id="sendMessage" class="btn btn-primary"><i class="bi bi-send"></i></button>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const chatHistory = document.getElementById('chatHistory');
  const userMessage = document.getElementById('userMessage');
  const sendMessage = document.getElementById('sendMessage');
  const quickOptions = document.querySelectorAll('.quick-option');

  // Respuestas del bot
  const botResponses = {
    "estado de reclamo": "Puedes verificar el estado de tu reclamo en la sección 'Mis Reclamos' de tu perfil.",
    "enviar sugerencia": "Por favor describe tu sugerencia y la enviaremos al equipo correspondiente.",
    "hablar con agente": "Conectándote con un agente humano, por favor espera...",
    "default": "No entendí tu solicitud. ¿Puedes ser más específico?"
  };

  // Añadir mensaje al chat
  function addMessage(sender, text) {
    const messageDiv = document.createElement('div');
    messageDiv.className = `${sender}-message mb-2`;
    
    const label = document.createElement('small');
    label.className = 'text-muted';
    label.textContent = sender === 'user' ? 'Tú:' : 'Soporte:';
    
    const content = document.createElement('div');
    content.className = `p-2 rounded d-inline-block ${sender === 'user' ? 'bg-primary text-white' : 'bg-secondary text-white'}`;
    content.textContent = text;
    
    messageDiv.appendChild(label);
    messageDiv.appendChild(document.createElement('br'));
    messageDiv.appendChild(content);
    
    chatHistory.appendChild(messageDiv);
    chatHistory.scrollTop = chatHistory.scrollHeight;
  }

  // Procesar mensaje del usuario
  function processUserMessage(message) {
    addMessage('user', message);
    
    setTimeout(() => {
      const lowerMsg = message.toLowerCase();
      let response = botResponses.default;
      
      if (lowerMsg.includes('reclamo')) response = botResponses["estado de reclamo"];
      if (lowerMsg.includes('sugerencia')) response = botResponses["enviar sugerencia"];
      if (lowerMsg.includes('agente') || lowerMsg.includes('humano')) response = botResponses["hablar con agente"];
      
      addMessage('bot', response);
    }, 500);
  }

  // Event listeners
  sendMessage.addEventListener('click', () => {
    const message = userMessage.value.trim();
    if (message) {
      processUserMessage(message);
      userMessage.value = '';
    }
  });

  userMessage.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
      sendMessage.click();
    }
  });

  quickOptions.forEach(option => {
    option.addEventListener('click', () => {
      processUserMessage(option.textContent);
    });
  });
});
</script>

<!-- Modal de Contacto -->
<div class="modal fade" id="modalContacto" tabindex="-1" aria-labelledby="modalContactoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content text-dark shadow">
      <!-- Encabezado -->
      <div class="modal-header text-white" style="background-color: #343a40;">
        <h5 class="modal-title" id="modalContactoLabel">
          <i class="bi bi-envelope me-2"></i> Contáctanos
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <!-- Cuerpo del modal -->
      <div class="modal-body">
        <p class="mb-3">¿Tienes dudas, sugerencias o reclamos? Escríbenos, llámanos o visítanos. ¡Estamos aquí para ayudarte!</p>

        <!-- Información de contacto -->
        <ul class="list-group list-group-flush mb-3">
          <li class="list-group-item">
            <i class="bi bi-envelope-at me-2 text-primary"></i>
            <a href="mailto:Reclamos.Sugerencias@gmail.com" class="text-decoration-none">Reclamos.Sugerencias@gmail.com</a>
          </li>
          <li class="list-group-item">
            <i class="bi bi-phone me-2 text-success"></i> +507 254-6511
          </li>
          <li class="list-group-item">
            <i class="bi bi-whatsapp me-2 text-success"></i>
            <a href="https://wa.me/50769316518" target="_blank" class="text-decoration-none">+507 6931-6518</a>
          </li>
          <li class="list-group-item">
            <i class="bi bi-geo-alt-fill me-2 text-danger"></i> Ciudad de Panamá, Panamá
          </li>
        </ul>

        <!-- Redes sociales -->
        <div class="mt-4">
          <h6 class="mb-2"><i class="bi bi-share-fill me-1"></i> Redes sociales</h6>
          <div class="d-flex gap-3">
            <a href="https://facebook.com/PlataformaReclamosPA" class="text-primary fs-4" target="_blank"><i class="bi bi-facebook"></i></a>
            <a href="https://instagram.com/PlataformaReclamosPA" class="text-danger fs-4" target="_blank"><i class="bi bi-instagram"></i></a>
            <a href="https://twitter.com/ReclamosPA" class="text-info fs-4" target="_blank"><i class="bi bi-twitter"></i></a>
          </div>
        </div>

        <hr class="my-4">

        <!-- Botón de acción -->
        <div class="text-end">
          <a href="mailto:Reclamos.Sugerencias@gmail.com" class="btn btn-primary">
            <i class="bi bi-send me-1"></i> Enviar mensaje ahora
          </a>
        </div>
      </div>
    </div>
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

<!-- jQuery primero, luego Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script de inicialización para asegurar el funcionamiento de los dropdowns -->
<script>


    // Cerrar dropdowns al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!e.target.matches('.dropdown-toggle') && !e.target.closest('.dropdown-menu')) {
            document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                menu.classList.remove('show');
            });
        }
    });
</script>

<?= $this->renderSection('scripts') ?>
</body>
</html>