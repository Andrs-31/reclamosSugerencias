<?= $this->extend('layouts/admin') ?>
<?= $this->section('contenido') ?>
  <h1 class="title">Bienvenido al Panel de Administración</h1>
  <div class="box">
    <p>Selecciona una opción del menú para comenzar.</p>
    <ul>
      <li><a href="/dashboard">Inicio</a></li>
      <li><a href="/reclamos">Ver Reclamos</a></li>
    </ul>
  </div>
<?= $this->endSection() ?>