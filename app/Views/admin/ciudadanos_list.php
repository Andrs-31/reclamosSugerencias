<?= $this->extend('layouts/admin') ?>

<?= $this->section('contenido') ?>
<div class="hero is-primary is-small">
  <div class="hero-body">
    <div class="container">
      <h1 class="title is-2 has-text-white">
        <span class="icon is-large">
          <i class="fas fa-user-friends"></i>
        </span>
        Gestión de Ciudadanos
      </h1>
      <p class="subtitle is-4 has-text-white">
        Administra los usuarios con rol de ciudadano
      </p>
    </div>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="box">
      <h2 class="title is-4">Ciudadanos Registrados</h2>
      <?php if (session()->getFlashdata('success')): ?>
        <div class="notification is-success">
          <?= session()->getFlashdata('success') ?>
        </div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('error')): ?>
        <div class="notification is-danger">
          <?= session()->getFlashdata('error') ?>
        </div>
      <?php endif; ?>
      <div class="table-container">
        <table class="table is-fullwidth is-striped is-hoverable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nombre de Usuario</th>
              <th>Email</th>
              <th>Rol</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($ciudadanos)): ?>
              <?php foreach ($ciudadanos as $ciudadano): ?>
                <tr>
                  <td><?= esc($ciudadano['id']) ?></td>
                  <td><?= esc($ciudadano['nombre']) ?></td>
                  <td><?= esc($ciudadano['email']) ?></td>
                  <td><?= esc($rolesMap[$ciudadano['rol_id']] ?? 'Desconocido') ?></td>
                  <td>
                    <div class="buttons is-small">
                       <!-- Botón para editar -->
                      <!-- <button class="button is-small is-light" title="Editar" onclick="openCitizenModal(<?= $ciudadano['id'] ?>, '<?= esc($ciudadano['nombre'], 'js') ?>', '<?= esc($ciudadano['email'], 'js') ?>')">
                        <span class="icon"><i class="fas fa-edit"></i></span>
                        <span>Editar</span>
                      </button> -->

                      <!-- Botón para ver reclamos -->
                      <a href="<?= base_url('reclamos/usuario_id/' . $ciudadano['id']) ?>" class="button is-small is-link" title="Ver Reclamos">
                        <span class="icon"><i class="fas fa-eye"></i></span>
                        <span>Reclamos</span>
                      </a>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="has-text-centered">No hay ciudadanos registrados.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<!-- Modal para Editar Ciudadano -->
<div id="citizen-modal" class="modal">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Editar Ciudadano</p>
      <button class="delete" aria-label="close" onclick="closeCitizenModal()"></button>
    </header>
    <section class="modal-card-body">
      <form id="citizen-form" action="<?= base_url('ciudadanos/save') ?>" method="post">
        <input type="hidden" name="id" id="citizen-id">
        <div class="field">
          <label class="label" for="citizen-nombre">Nombre de Usuario</label>
          <div class="control">
            <input class="input" type="text" name="nombre" id="citizen-nombre_usuario" required>
          </div>
        </div>
        <div class="field">
          <label class="label" for="citizen-email">Email</label>
          <div class="control">
            <input class="input" type="email" name="email" id="citizen-email" required>
          </div>
        </div>
        <!-- Para cambiar la contaseña  -->
        <!-- <div class="field">
          <label class="label" for="citizen-password">Nueva Contraseña (opcional)</label>
          <div class="control">
            <input class="input" type="password" name="password" id="citizen-password">
          </div>
        </div> -->
      </form>
    </section>
    <footer class="modal-card-foot">
      <button class="button is-success is-light" type="submit" form="citizen-form">Guardar Cambios</button>
      <button class="button is-light" onclick="closeCitizenModal()">Cancelar</button>
    </footer>
  </div>
</div>

<script>
  function openCitizenModal(id, nombre, email) {
    const modal = document.getElementById('citizen-modal');
    document.getElementById('citizen-id').value = id;
    document.getElementById('citizen-nombre_usuario').value = nombre;
    document.getElementById('citizen-email').value = email;
    modal.classList.add('is-active');
  }

  function closeCitizenModal() {
    document.getElementById('citizen-modal').classList.remove('is-active');
  }

  document.querySelector('#citizen-modal .delete').addEventListener('click', closeCitizenModal);
</script>
<?= $this->endSection() ?>
