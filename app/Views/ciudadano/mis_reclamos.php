<?= $this->extend('layouts/ciudadano') ?>
<?= $this->section('contenido') ?>
  <h1 class="title">Mis Reclamos</h1>
  
  <div class="level">
    <div class="level-left">
      <div class="level-item">
        <p class="subtitle is-5">Aquí puedes ver y gestionar todos tus reclamos</p>
      </div>
    </div>
    <div class="level-right">
      <div class="level-item">
        <a href="/reclamosSugerencias/public/ciudadano/nuevo-reclamo" class="button is-primary">
          <span class="icon">
            <i class="fas fa-plus"></i>
          </span>
          <span>Nuevo Reclamo</span>
        </a>
      </div>
    </div>
  </div>
  
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
  
  <?php if (empty($reclamos)): ?>
    <div class="notification is-info">
      <p>No tienes reclamos registrados.</p>
    </div>
  <?php else: ?>
    <table class="table is-striped is-fullwidth">
      <thead>
        <tr>
          <th>ID</th>
          <th>Categoría</th>
          <th>Descripción</th>
          <th>Estado</th>
          <th>Fecha de Creación</th>
          <th>Última Actualización</th>
          <th>Respuesta</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($reclamos as $reclamo): ?>
          <tr data-id="<?= $reclamo['id'] ?>">
            <td><?= esc($reclamo['id']) ?></td>
            <td><?= esc($reclamo['categoria_nombre'] ?? 'Sin categoría') ?></td>
            <td>
              <div style="max-width: 300px; word-wrap: break-word;">
                <?= esc($reclamo['descripcion']) ?>
              </div>
            </td>
            <td>
              <span class="tag <?= $reclamo['estado'] == 'pendiente' ? 'is-warning' : (in_array($reclamo['estado'], ['resuelto', 'solucionado']) ? 'is-success' : 'is-danger') ?>">
                <?= esc(ucfirst($reclamo['estado'])) ?>
              </span>
            </td>
            <td><?= esc(date('d/m/Y H:i', strtotime($reclamo['fecha']))) ?></td>
            <td>
              <?php if ($reclamo['fecha_actualizacion']): ?>
                <?= esc(date('d/m/Y H:i', strtotime($reclamo['fecha_actualizacion']))) ?>
              <?php else: ?>
                <span class="has-text-grey">Sin actualizar</span>
              <?php endif; ?>
            </td>
            <td>
              <?php if (isset($reclamo['tiene_respuesta']) && $reclamo['tiene_respuesta']): ?>
                <a href="/reclamosSugerencias/public/ciudadano/ver-respuesta/<?= $reclamo['id'] ?>" class="button is-small is-info">
                  <span class="icon is-small">
                    <i class="fas fa-eye"></i>
                  </span>
                  <span>Ver Respuesta</span>
                </a>
              <?php else: ?>
                <span class="button is-small is-light" disabled>
                  <span class="icon is-small">
                    <i class="fas fa-clock"></i>
                  </span>
                  <span>Sin Respuesta</span>
                </span>
              <?php endif; ?>
            </td>
            <td>
              <div class="buttons">
                <?php if (in_array($reclamo['estado'], ['resuelto', 'solucionado'])): ?>
                  <!-- Botón Editar deshabilitado para reclamos solucionados -->
                  <button class="button is-small is-light" disabled title="No se puede editar un reclamo solucionado">
                    <span class="icon is-small">
                      <i class="fas fa-edit"></i>
                    </span>
                    <span>Editar</span>
                  </button>
                <?php else: ?>
                  <!-- Botón Editar activo para reclamos pendientes -->
                  <a href="/reclamosSugerencias/public/ciudadano/editar-reclamo/<?= $reclamo['id'] ?>" class="button is-small is-info">
                    <span class="icon is-small">
                      <i class="fas fa-edit"></i>
                    </span>
                    <span>Editar</span>
                  </a>
                <?php endif; ?>
                
                <?php if (in_array($reclamo['estado'], ['resuelto', 'solucionado'])): ?>
                  <!-- Botón Eliminar deshabilitado para reclamos solucionados -->
                  <button class="button is-small is-light" disabled title="No se puede eliminar un reclamo solucionado">
                    <span class="icon is-small">
                      <i class="fas fa-trash"></i>
                    </span>
                    <span>Eliminar</span>
                  </button>
                <?php else: ?>
                  <!-- Botón Eliminar activo para reclamos pendientes -->
                  <button class="button is-small is-danger" onclick="confirmarEliminacion(<?= $reclamo['id'] ?>)">
                    <span class="icon is-small">
                      <i class="fas fa-trash"></i>
                    </span>
                    <span>Eliminar</span>
                  </button>
                <?php endif; ?>
              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <script>
    function confirmarEliminacion(id) {
      if (confirm('¿Estás seguro de que deseas eliminar este reclamo? Esta acción no se puede deshacer.')) {
        // Hacer petición AJAX para eliminar
        fetch('/reclamosSugerencias/public/ciudadano/eliminar-reclamo/' + id, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Mostrar mensaje de éxito
            mostrarNotificacion('success', data.message);
            // Eliminar la fila de la tabla
            document.querySelector(`tr[data-id="${id}"]`).remove();
            // Verificar si quedan reclamos
            verificarReclamosRestantes();
          } else {
            mostrarNotificacion('danger', data.message);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          mostrarNotificacion('danger', 'Error al eliminar el reclamo. Inténtalo de nuevo.');
        });
      }
    }

    function mostrarNotificacion(tipo, mensaje) {
      // Crear elemento de notificación
      const notification = document.createElement('div');
      notification.className = `notification is-${tipo}`;
      notification.innerHTML = `
        <button class="delete"></button>
        ${mensaje}
      `;
      
      // Insertar al inicio del contenido
      const contenido = document.querySelector('.section .container');
      const titulo = contenido.querySelector('.title');
      contenido.insertBefore(notification, titulo.nextSibling);
      
      // Agregar evento para cerrar
      notification.querySelector('.delete').addEventListener('click', () => {
        notification.remove();
      });
      
      // Auto-eliminar después de 5 segundos
      setTimeout(() => {
        if (notification.parentNode) {
          notification.remove();
        }
      }, 5000);
    }

    function verificarReclamosRestantes() {
      const tbody = document.querySelector('tbody');
      if (tbody && tbody.children.length === 0) {
        // No quedan reclamos, mostrar mensaje informativo
        const table = document.querySelector('.table');
        const infoDiv = document.createElement('div');
        infoDiv.className = 'notification is-info';
        infoDiv.innerHTML = '<p>No tienes reclamos registrados.</p>';
        table.parentNode.replaceChild(infoDiv, table);
      }
    }

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
