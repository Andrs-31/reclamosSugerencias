
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
      <tr>
        <td>1</td>
        <td>Juan Pérez</td>
        <td>Problema con el servicio</td>
        <td>2025-07-13</td>
      </tr>
      <tr>
        <td>2</td>
        <td>María López</td>
        <td>Solicitud de información</td>
        <td>2025-07-12</td>
      </tr>
    </tbody>
  </table>
<?= $this->endSection() ?>