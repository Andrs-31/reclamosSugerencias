<aside class="menu has-background-dark sidebar-fixed" style="padding: 1.5rem; width: 280px; min-height: 100vh; overflow-x: hidden; ">

<div class="has-text-centered mb-1">
  <figure class="image is-256x256 is-inline-block mb-1"> <!-- Añadido mb-1 al figure -->
    <img class="is-rounded" src="<?= base_url('img/logo.png') ?>" alt="Logo">
  </figure>
  <h1 class="title is-4 has-text-white">Panel de Administración</h1>

  
</div>

  <hr class="has-background-grey-dark">

  <ul class="menu-list">
    <!-- Inicio -->
    <li>
      <a href="<?= base_url('dashboard') ?>" class="has-text-white">
        <span class="icon"><i class="fas fa-home"></i></span>
        <span>Inicio</span>
      </a>
    </li>

    <!-- Gestión de Reclamos (Desplegable) -->
    <li>
      <a class="has-text-white is-flex is-align-items-center is-justify-content-space-between" onclick="toggleMenu('submenu-reclamos')">
        <span>
          <span class="icon"><i class="fas fa-clipboard-list"></i></span>
          <span>Gestión de Reclamos</span>
        </span>
        <span class="icon"><i class="fas fa-chevron-down" id="arrow-submenu-reclamos"></i></span>
      </a>
      <ul id="submenu-reclamos" class="is-hidden ml-4 mt-1">
        <li><a href="<?= base_url('reclamos') ?>" class="has-text-white">Todos los Reclamos</a></li>
        <li>
  <a href="<?= base_url('reclamos/pendiente') ?>" class="has-text-white">
    Pendientes 
    <span id="count-pendientes" class="tag is-warning is-rounded is-size-7 ml-2 has-text-weight-bold">
      <?= esc($reclamosPendientes ?? 0) ?>
    </span>
  </a>
</li>
<li>
  <a href="<?= base_url('reclamos/en_proceso') ?>" class="has-text-white">
    En Proceso 
    <span id="count-enproceso" class="tag is-info is-rounded is-size-7 ml-2 has-text-weight-bold">
      <?= esc($reclamosEnProceso ?? 0) ?>
    </span>
  </a>
</li>
<li>
  <a href="<?= base_url('reclamos/solucionado') ?>" class="has-text-white">
    Solucionados 
    <span id="count-solucionados" class="tag is-success is-rounded is-size-7 ml-2 has-text-weight-bold">
      <?= esc($reclamosSolucionados ?? 0) ?>
    </span>
  </a>
</li>

      </ul>
    </li>

    <!-- Categorías -->
    <li>
      <a href="<?= base_url('categorias') ?>" class="has-text-white">
        <span class="icon"><i class="fas fa-tag"></i></span>
        <span>Categorías</span>
      </a>
    </li>

    <!-- Ciudadanos -->
    <li>
      <a href="<?= base_url('ciudadanos') ?>" class="has-text-white">
        <span class="icon"><i class="fas fa-user-friends"></i></span>
        <span>Ciudadanos</span>
      </a>
    </li>
  </ul>

  <hr class="has-background-grey-dark">

<!-- Usuario fijo abajo -->
  <div style="position: absolute; bottom: 1rem; left: 0; right: 0;">
    <div class="has-text-centered">
      <div class="dropdown is-up is-hoverable">
        <div class="dropdown-trigger">
          <button class="button is-dark is-fullwidth" aria-haspopup="true" aria-controls="dropdown-menu">
            <span class="icon"><i class="fas fa-user-circle"></i></span>
            <span>Administrador</span>
            <span class="icon is-small"><i class="fas fa-angle-up" aria-hidden="true"></i></span>
          </button>
        </div>
        <div class="dropdown-menu" id="dropdown-menu" role="menu">
          <div class="dropdown-content">
            <a href="<?= base_url('logout') ?>" class="dropdown-item has-text-danger">
              <span class="icon"><i class="fas fa-sign-out-alt"></i></span>
              <span>Cerrar Sesión</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</aside>
