
<?= $this->extend('layouts/admin') ?>
<?= $this->section('contenido') ?>
  <h1 class="title">Reclamos Registrados</h1>
  <table class="table is-striped is-fullwidth">
    <thead>
      <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Descripción</th>
        <th>Fecha</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($reclamos as $reclamo): ?>
        <tr>
          <td><?= esc($reclamo['id']) ?></td>
          <td><?= esc($reclamo['usuario_id']) ?></td>
          <td><?= esc($reclamo['descripcion']) ?></td>
          <td><?= esc($reclamo['fecha']) ?></td>
        </tr>
      <?php endforeach; ?>
    
  </table>

  <table class="table is-striped is-fullwidth">
    <thead>
      <tr>
        <th>ID</th>
        <th>IDreclamo</th>
        <th>comentario</th>
        <th>Fecha</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($comentarios as $comentario): ?>
        <tr>
          <td><?= esc($comentario['id']) ?></td>
          <td><?= esc($comentario['reclamo_id']) ?></td>
          <td><?= esc($comentario['comentario']) ?></td>
          <td><?= esc($comentario['fecha']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <table class="table is-striped is-fullwidth">
    <thead>
      <tr>
        <th>nombre</th>
        <th>email</th>
        <th>Contraseña</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($usuarios as $usuario): ?>
        <tr>
          <td><?= esc($usuario['nombre_usuario']) ?></td>
          <td><?= esc($usuario['email']) ?></td>
          <td><?= esc($usuario['password']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?= $this->endSection() ?>

