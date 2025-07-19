<?= $this->extend('layouts/ciudadano') ?>
<?= $this->section('contenido') ?>
  <h1 class="title">Nuevo Reclamo</h1>
  
  <?php if (session()->getFlashdata('success')): ?>
    <div class="notification is-success">
      <button class="delete"></button>
      <?= session()->getFlashdata('success') ?>
    </div>
  <?php endif; ?>
  
  <?php if (session()->getFlashdata('error')): ?>
    <div class="notification is-danger">
      <button class="delete"></button>
      <?= session()->getFlashdata('error') ?>
    </div>
  <?php endif; ?>
  
  <div class="columns">
    <div class="column is-12">
      <div class="box">
        <form action="/reclamosSugerencias/public/ciudadano/guardar-reclamo" method="post">
          <?= csrf_field() ?>
          
          <div class="field">
            <label class="label">Categoría <span class="has-text-danger">*</span></label>
            <div class="control">
              <div class="select is-fullwidth">
                <select name="categoria_id" required>
                  <option value="">Selecciona una categoría</option>
                  <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= esc($categoria['id']) ?>" <?= old('categoria_id') == $categoria['id'] ? 'selected' : '' ?>>
                      <?= esc($categoria['nombre_categoria']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

          <div class="field">
            <label class="label">Descripción del Reclamo <span class="has-text-danger">*</span></label>
            <div class="control">
              <textarea class="textarea" name="descripcion" placeholder="Describe detalladamente tu reclamo o sugerencia..." rows="8" required><?= old('descripcion') ?></textarea>
            </div>
            <p class="help">Proporciona todos los detalles posibles para que podamos atender tu reclamo de manera eficiente.</p>
          </div>

          <div class="field is-grouped">
            <div class="control">
              <button type="submit" class="button is-primary">
                <span class="icon">
                  <i class="fas fa-paper-plane"></i>
                </span>
                <span>Enviar Reclamo</span>
              </button>
            </div>
            <div class="control">
              <a href="/reclamosSugerencias/public/ciudadano/mis-reclamos" class="button is-light">
                <span class="icon">
                  <i class="fas fa-arrow-left"></i>
                </span>
                <span>Volver a Mis Reclamos</span>
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    // Manejar el botón de cerrar notificaciones
    document.addEventListener('DOMContentLoaded', function () {
      (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
        const $notification = $delete.parentNode;
        $delete.addEventListener('click', () => {
          $notification.parentNode.removeChild($notification);
        });
      });
    });
  </script>
<?= $this->endSection() ?>
