<?= $this->extend('layouts/admin') ?>

<?= $this->section('contenido') ?>
<div class="hero is-primary is-small">
  <div class="hero-body">
    <div class="container">
      <h1 class="title is-2 has-text-white">
        <span class="icon is-large">
          <i class="fas fa-tags"></i>
        </span>
        Gestión de Categorías
      </h1>
      <p class="subtitle is-4 has-text-white">
        Administra las categorías de reclamos
      </p>
    </div>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="columns is-vcentered is-mobile">
      <div class="column is-full has-text-right">
        <button class="button is-success is-light" onclick="openCategoryModal()">
          <span class="icon">
            <i class="fas fa-plus"></i>
          </span>
          <span>Añadir Nueva Categoría</span>
        </button>
      </div>
    </div>

    <div class="box">
      <h2 class="title is-4">Categorías Registradas</h2>
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
              <th>Nombre de Categoría</th>
              <th>Descripción</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($categorias)): ?>
              <?php foreach ($categorias as $categoria): ?>
                <tr>
                  <td><?= esc($categoria['id']) ?></td>
                  <td><?= esc($categoria['nombre_categoria']) ?></td>
                  <td><?= esc($categoria['descripcion'] ?? 'Sin descripción') ?></td>
                  <td>
                    <div class="buttons is-small">
                      <button class="button is-small is-light" title="Editar" onclick="openCategoryModal(<?= $categoria['id'] ?>, '<?= esc($categoria['nombre_categoria'], 'js') ?>', '<?= esc($categoria['descripcion'] ?? '', 'js') ?>')">
                        <span class="icon"><i class="fas fa-edit"></i></span>
                        <span>Editar</span>
                      </button>
                      <!-- <a href="<?= base_url('categorias/delete/' . $categoria['id']) ?>" class="button is-small is-danger is-light" title="Eliminar" onclick="return confirm('¿Está seguro de eliminar esta categoría?');">
                        <span class="icon"><i class="fas fa-trash"></i></span>
                        <span>Eliminar</span>
                      </a> -->
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="4" class="has-text-centered">No hay categorías registradas.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<!-- Modal para Añadir/Editar Categoría -->
<div id="category-modal" class="modal">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title" id="category-modal-title">Añadir Categoría</p>
      <button class="delete" aria-label="close" onclick="closeCategoryModal()"></button>
    </header>
    <section class="modal-card-body">
      <form id="category-form" action="<?= base_url('categorias/save') ?>" method="post">
        <input type="hidden" name="id" id="category-id">
        <div class="field">
          <label class="label" for="nombre_categoria">Nombre de la Categoría</label>
          <div class="control">
            <input class="input" type="text" name="nombre_categoria" id="nombre_categoria" placeholder="Ej. Agua, Luz, Basura" required>
          </div>
        </div>
        <div class="field">
          <label class="label" for="descripcion">Descripción</label>
          <div class="control">
            <textarea class="textarea" name="descripcion" id="descripcion" placeholder="Breve descripción de la categoría"></textarea>
          </div>
        </div>
      </form>
    </section>
    <footer class="modal-card-foot">
      <button class="button is-success is-light" type="submit" form="category-form">Guardar</button>
      <button class="button is-light" onclick="closeCategoryModal()">Cancelar</button>
    </footer>
  </div>
</div>

<script>
  function openCategoryModal(id = null, name = '', description = '') {
    const modal = document.getElementById('category-modal');
    const title = document.getElementById('category-modal-title');
    const categoryIdInput = document.getElementById('category-id');
    const categoryNameInput = document.getElementById('nombre_categoria');
    const categoryDescriptionInput = document.getElementById('descripcion');

    if (id) {
      title.textContent = 'Editar Categoría';
      categoryIdInput.value = id;
      categoryNameInput.value = name;
      categoryDescriptionInput.value = description;
    } else {
      title.textContent = 'Añadir Categoría';
      categoryIdInput.value = '';
      categoryNameInput.value = '';
      categoryDescriptionInput.value = '';
    }
    modal.classList.add('is-active');
  }

  function closeCategoryModal() {
    document.getElementById('category-modal').classList.remove('is-active');
  }

  document.querySelector('#category-modal .delete').addEventListener('click', closeCategoryModal);
</script>
<?= $this->endSection() ?>
