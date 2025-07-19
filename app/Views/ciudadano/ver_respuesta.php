<?= $this->extend('layouts/ciudadano') ?>
<?= $this->section('contenido') ?>
  <h1 class="title">Respuesta al Reclamo #<?= esc($reclamo['id']) ?></h1>
  
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
      <!-- Información del reclamo original -->
      <div class="box">
        <h4 class="title is-5">Tu Reclamo Original</h4>
        <div class="content">
          <p><strong>Categoría:</strong> <?= esc($reclamo['categoria_nombre'] ?? 'Sin categoría') ?></p>
          <p><strong>Descripción:</strong></p>
          <div class="box has-background-light">
            <?= esc($reclamo['descripcion']) ?>
          </div>
          <p><strong>Estado:</strong> 
            <span class="tag <?= $reclamo['estado'] == 'pendiente' ? 'is-warning' : (in_array($reclamo['estado'], ['resuelto', 'solucionado']) ? 'is-success' : ($reclamo['estado'] == 'en_proceso' ? 'is-info' : 'is-danger')) ?>">
              <?= esc(ucfirst($reclamo['estado'])) ?>
            </span>
          </p>
        </div>
      </div>
      
      <!-- Conversación completa -->
      <div class="box">
        <h4 class="title is-5">Conversación con el Administrador</h4>
        <div class="content">
          <?php if (empty($todosComentarios)): ?>
            <div class="notification is-warning">
              <p>Aún no hay respuestas para este reclamo.</p>
            </div>
          <?php else: ?>
            <!-- Mostrar todos los comentarios en orden cronológico -->
            <div class="timeline">
              <?php foreach ($todosComentarios as $comentario): ?>
                <?php if ($comentario['rol_id'] == 1): ?> <!-- rol_id = 1 es ciudadano -->
                  <!-- Comentario del ciudadano -->
                  <div class="box has-background-success-light mb-4">
                    <div class="media">
                      <div class="media-left">
                        <span class="icon has-text-success">
                          <i class="fas fa-user"></i>
                        </span>
                      </div>
                      <div class="media-content">
                        <div class="content">
                          <p>
                            <strong class="has-text-success">Tú escribiste:</strong>
                            <small class="has-text-grey">
                              <?= esc(date('d/m/Y H:i', strtotime($comentario['fecha']))) ?>
                            </small>
                          </p>
                          <p><?= esc($comentario['comentario']) ?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php else: ?> <!-- cualquier otro rol_id es admin -->
                  <!-- Comentario del administrador -->
                  <div class="box has-background-info-light mb-4">
                    <div class="media">
                      <div class="media-left">
                        <span class="icon has-text-info">
                          <i class="fas fa-user-shield"></i>
                        </span>
                      </div>
                      <div class="media-content">
                        <div class="content">
                          <p>
                            <strong class="has-text-info">Administrador respondió:</strong>
                            <small class="has-text-grey">
                              <?= esc(date('d/m/Y H:i', strtotime($comentario['fecha']))) ?>
                            </small>
                          </p>
                          <p><?= esc($comentario['comentario']) ?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <?php if (!empty($comentariosAdmin)): ?>
        <!-- Formulario para responder al administrador -->
        <div class="box">
          <h4 class="title is-5">Continuar la Conversación</h4>
          <form action="/reclamosSugerencias/public/ciudadano/responder-comentario/<?= $reclamo['id'] ?>" method="post">
            <?= csrf_field() ?>
            <div class="field">
              <label class="label">Tu respuesta</label>
              <div class="control">
                <textarea class="textarea" name="respuesta_ciudadano" placeholder="Escribe tu respuesta o consulta adicional..." rows="4" required><?= old('respuesta_ciudadano') ?></textarea>
              </div>
              <p class="help">Puedes agregar comentarios adicionales o consultas sobre las respuestas del administrador.</p>
            </div>
            <div class="field">
              <div class="control">
                <button type="submit" class="button is-info">
                  <span class="icon">
                    <i class="fas fa-reply"></i>
                  </span>
                  <span>Enviar Respuesta</span>
                </button>
              </div>
            </div>
          </form>
        </div>
      <?php endif; ?>

      <!-- Formulario para cambiar estado a solucionado -->
      <?php if (in_array($reclamo['estado'], ['pendiente', 'en_proceso'])): ?>
        <div class="box has-background-success-light">
          <h4 class="title is-5">¿Tu problema fue solucionado?</h4>
          <div class="content">
            <?php if ($reclamo['estado'] == 'pendiente'): ?>
              <p>Si el administrador ha resuelto tu reclamo satisfactoriamente, puedes marcarlo como <strong>solucionado</strong>.</p>
            <?php else: ?>
              <p>Tu reclamo está en proceso, pero si ya consideras que ha sido resuelto satisfactoriamente por el administrador, puedes marcarlo como <strong>solucionado</strong>.</p>
            <?php endif; ?>
            <p class="has-text-warning">
              <span class="icon">
                <i class="fas fa-exclamation-triangle"></i>
              </span>
              <strong>Nota:</strong> Una vez marcado como solucionado, no se puede deshacer esta acción.
            </p>
          </div>
          <form action="/reclamosSugerencias/public/ciudadano/marcar-solucionado/<?= $reclamo['id'] ?>" method="post" onsubmit="return confirm('¿Estás seguro de que tu reclamo ha sido solucionado? Esta acción no se puede deshacer.')">
            <?= csrf_field() ?>
            <div class="field">
              <div class="control">
                <button type="submit" class="button is-success">
                  <span class="icon">
                    <i class="fas fa-check-circle"></i>
                  </span>
                  <span>Marcar como Solucionado</span>
                </button>
              </div>
            </div>
          </form>
        </div>
      <?php elseif (in_array($reclamo['estado'], ['resuelto', 'solucionado'])): ?>
        <div class="notification is-success">
          <p><strong>✓ Este reclamo ya ha sido marcado como solucionado.</strong></p>
        </div>
      <?php endif; ?>
      
      <div class="field">
        <div class="control">
          <a href="/reclamosSugerencias/public/ciudadano/mis-reclamos" class="button is-primary">
            <span class="icon">
              <i class="fas fa-arrow-left"></i>
            </span>
            <span>Volver a Mis Reclamos</span>
          </a>
        </div>
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
