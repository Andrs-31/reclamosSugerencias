<?= $this->extend('layouts/ciudadano') ?>
<?= $this->section('contenido') ?>
  <h1 class="title">Editar Reclamo</h1>
  
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
        <form action="../actualizar-reclamo/<?= $reclamo['id'] ?>" method="post">
          <?= csrf_field() ?>
          
          <div class="field">
            <label class="label">ID del Reclamo</label>
            <div class="control">
              <input class="input" type="text" value="<?= esc($reclamo['id']) ?>" readonly>
            </div>
          </div>

          <div class="field">
            <label class="label">Categoría <span class="has-text-danger">*</span></label>
            <div class="control">
              <div class="select is-fullwidth">
                <select name="categoria_id" required>
                  <option value="">Selecciona una categoría</option>
                  <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= esc($categoria['id']) ?>" <?= $reclamo['categoria_id'] == $categoria['id'] ? 'selected' : '' ?>>
                      <?= esc($categoria['nombre_categoria']) ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>

          <div class="field">
            <label class="label">Descripción <span class="has-text-danger">*</span></label>
            <div class="control">
              <textarea class="textarea" name="descripcion" placeholder="Describe tu reclamo..." rows="6" required><?= esc($reclamo['descripcion']) ?></textarea>
            </div>
          </div>

          <!-- Campo de estado siempre readonly -->
          <div class="field">
            <label class="label">Estado Actual</label>
            <div class="control">
              <input class="input" type="text" value="<?= esc(ucfirst($reclamo['estado'])) ?>" readonly>
              <input type="hidden" name="estado" value="<?= esc($reclamo['estado']) ?>">
            </div>
            <?php if ($reclamo['estado'] == 'pendiente'): ?>
              <p class="help">El estado actual es "Pendiente". Puedes usar el botón de abajo para marcarlo como solucionado si tu problema fue resuelto.</p>
            <?php elseif ($reclamo['estado'] == 'en_proceso'): ?>
              <p class="help has-text-info">
                <span class="icon">
                  <i class="fas fa-clock"></i>
                </span>
                El estado actual es "En Proceso". El administrador está trabajando en tu reclamo. Puedes usar el botón de abajo para marcarlo como solucionado si tu problema fue resuelto.
              </p>
            <?php else: ?>
              <p class="help has-text-success">
                <span class="icon">
                  <i class="fas fa-check-circle"></i>
                </span>
                Este reclamo ya ha sido marcado como solucionado.
              </p>
            <?php endif; ?>
          </div>

          <div class="field is-grouped">
            <div class="control">
              <button type="submit" class="button is-primary">
                <span class="icon">
                  <i class="fas fa-save"></i>
                </span>
                <span>Guardar Cambios</span>
              </button>
            </div>
            <div class="control">
              <a href="../mis-reclamos" class="button is-light">
                <span class="icon">
                  <i class="fas fa-arrow-left"></i>
                </span>
                <span>Cancelar</span>
              </a>
            </div>
          </div>
        </form>
      </div>

      <!-- Sección separada para marcar como solucionado -->
      <?php if ($reclamo['estado'] == 'pendiente' || $reclamo['estado'] == 'en_proceso'): ?>
        <div class="box has-background-success-light">
          <h4 class="title is-5">¿Tu problema fue solucionado?</h4>
          <div class="content">
            <?php if ($reclamo['estado'] == 'pendiente'): ?>
              <p>Si consideras que tu reclamo ha sido resuelto satisfactoriamente, puedes marcarlo como <strong>solucionado</strong>.</p>
            <?php else: ?>
              <p>Tu reclamo está en proceso, pero si ya consideras que el problema ha sido resuelto satisfactoriamente, puedes marcarlo como <strong>solucionado</strong>.</p>
            <?php endif; ?>
            <p class="has-text-warning">
              <span class="icon">
                <i class="fas fa-exclamation-triangle"></i>
              </span>
              <strong>Nota:</strong> Una vez marcado como solucionado, no podrás cambiar el estado nuevamente.
            </p>
          </div>
          <form action="../marcar-solucionado/<?= $reclamo['id'] ?>" method="post" onsubmit="return confirm('¿Estás seguro de que tu reclamo ha sido solucionado? Esta acción no se puede deshacer.')">
            <?= csrf_field() ?>
            <div class="field">
              <div class="control">
                <button type="submit" class="button is-success is-medium">
                  <span class="icon">
                    <i class="fas fa-check-circle"></i>
                  </span>
                  <span>Marcar como Solucionado</span>
                </button>
              </div>
            </div>
          </form>
        </div>
      <?php endif; ?>
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
