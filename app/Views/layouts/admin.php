<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($titulo ?? 'Panel de Administración') ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    .main-content {
      margin-left: 280px;
      min-height: 100vh;
      background-color: #f8f9fa;
    }

    .sidebar-fixed {
      position: fixed;
      top: 0;
      left: 0;
      height: 100vh;
      width: 220px;
      z-index: 1000;
      overflow-y: auto;
    }

    .hero.is-primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .hero.is-info {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .card {
      box-shadow: 0 0.5em 1em -0.125em rgba(10, 10, 10, 0.1), 0 0px 0 1px rgba(10, 10, 10, 0.02);
      border-radius: 8px;
    }

    .table td, .table th {
      vertical-align: middle;
    }

    .notification {
      border-radius: 8px;
    }

    @media screen and (max-width: 768px) {
      .main-content {
        margin-left: 0;
      }
      
      .sidebar-fixed {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
      }
      
      .sidebar-fixed.is-active {
        transform: translateX(0);
      }
    }

    .menu-label {
      color: #b5b5b5;
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.75rem;
    }

    .menu-list a {
      border-radius: 4px;
      color: #dbdbdb;
      transition: all 0.3s ease;
    }

    .menu-list a:hover {
      background-color: rgba(255, 255, 255, 0.1);
      color: #fff;
    }

    .menu-list a.is-active {
      background-color: #3273dc;
      color: #fff;
    }
  </style>
</head>
<body>
  <!-- Pasar los datos de conteo a la vista parcial navbarVerAdmin -->
  <?= view('componentes/navbarVerAdmin', [
      'reclamosPendientes' => $reclamosPendientes ?? 0,
      'reclamosEnProceso' => $reclamosEnProceso ?? 0,
      'reclamosSolucionados' => $reclamosSolucionados ?? 0,
  ]) ?>
 <div class="main-content">
    <?= $this->renderSection('contenido') ?>
  </div>

  <?= $this->include('admin/reclamo_modal') ?>

  <button class="button is-primary is-fixed" id="mobile-menu-toggle" style="display: none; position: fixed; top: 1rem; left: 1rem; z-index: 1001;">
    <span class="icon">
      <i class="fas fa-bars"></i>
    </span>
  </button>

  <script>

  // Función que actualiza los contadores desde el backend
  function actualizarContadoresReclamos() {
    fetch('<?= base_url('admin/reclamos/contar') ?>')
      .then(response => response.json())
      .then(data => {
        document.getElementById('count-pendientes').textContent = data.reclamosPendientes;
        document.getElementById('count-enproceso').textContent = data.reclamosEnProceso;
        document.getElementById('count-solucionados').textContent = data.reclamosSolucionados;
      })
      .catch(error => console.error('Error al actualizar contadores:', error));
  }

  // Detecta cierre del modal de reclamo
  const modal = document.getElementById('reclamo-modal'); // Asegúrate que este sea el ID correcto del modal

  if (modal) {
    const observer = new MutationObserver((mutationsList) => {
      for (let mutation of mutationsList) {
        if (mutation.attributeName === "class") {
          const isActive = modal.classList.contains('is-active');
          if (!isActive) {
            actualizarContadoresReclamos(); // Se actualizan al cerrar
          }
        }
      }
    });

    observer.observe(modal, { attributes: true });
  }

    // Manejo del menú móvil
    const mobileToggle = document.getElementById('mobile-menu-toggle');
    const sidebar = document.querySelector('.sidebar-fixed');
    
    if (window.innerWidth <= 768) {
      mobileToggle.style.display = 'block';
    }
    
    mobileToggle.addEventListener('click', () => {
      sidebar.classList.toggle('is-active');
    });
    
    document.addEventListener('click', (e) => {
      if (window.innerWidth <= 768 && 
          !sidebar.contains(e.target) && 
          !mobileToggle.contains(e.target)) {
        sidebar.classList.remove('is-active');
      }
    });
    
    window.addEventListener('resize', () => {
      if (window.innerWidth <= 768) {
        mobileToggle.style.display = 'block';
      } else {
        mobileToggle.style.display = 'none';
        sidebar.classList.remove('is-active');
      }
    });

    // Función para los submenús desplegables
    function toggleMenu(id) {
      const submenu = document.getElementById(id);
      const arrow = document.getElementById("arrow-" + id);
      submenu.classList.toggle("is-hidden");
      arrow.classList.toggle("fa-chevron-down");
      arrow.classList.toggle("fa-chevron-up");
    }
  </script>
</body>
</html>