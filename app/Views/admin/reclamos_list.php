<?= $this->extend('layouts/admin') ?>

<?= $this->section('contenido') ?>
<div class="hero is-primary is-small">
  <div class="hero-body">
    <div class="container">
      <h1 class="title is-2 has-text-white">
        <span class="icon is-large">
          <i class="fas fa-clipboard-list"></i>
        </span>
        Gestión de Reclamos
      </h1>
      <p class="subtitle is-4 has-text-white">
        Listado completo de reclamos y sugerencias
      </p>
    </div>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="columns is-vcentered is-mobile">
      <div class="column is-full">
        <form action="<?= base_url('reclamos') ?>" method="get">
          <!-- Primera fila: Buscador y botones -->
          <div class="field is-grouped is-grouped-multiline">
            <!-- Campo de búsqueda -->
            <div class="control is-expanded">
              <input class="input" type="text" name="search" placeholder="Buscar..." value="<?= esc($searchTerm ?? '') ?>">
            </div>
            
            <!-- Botón de filtros -->
            <div class="control">
              <button type="button" id="toggle-filters" class="button is-light">
                <span class="icon">
                  <i class="fas fa-filter"></i>
                </span>
                <span>Filtros</span>
              </button>
            </div>
            
            <!-- Botón de búsqueda -->
            <div class="control">
              <button type="submit" class="button is-primary">
                <span class="icon">
                  <i class="fas fa-search"></i>
                </span>
                <span>Buscar</span>
              </button>
            </div>
          </div>
          
          <!-- Sección de filtros (oculta inicialmente) -->
          <div id="filters-section" class="box" style="display: none; margin-top: 1rem;">
            <div class="columns is-multiline">
              <!-- Provincia -->
              <div class="column is-one-third">
                <div class="field">
                  <label class="label">Provincia</label>
                  <div class="control">
                    <div class="select is-fullwidth">
                      <select id="provincia" name="provincia">
                        <option value="">Seleccione provincia</option>
                        <?php foreach($provincias as $prov): ?>
                          <option value="<?= $prov['codigo_provincia'] ?>" 
                            <?= ($prov['codigo_provincia'] == ($selectedProvincia ?? '')) ? 'selected' : '' ?>>
                            <?= $prov['nombre_provincia'] ?>
                          </option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Distrito -->
              <div class="column is-one-third">
                <div class="field">
                  <label class="label">Distrito</label>
                  <div class="control">
                    <div class="select is-fullwidth">
                      <select id="distrito" name="distrito" <?= empty($selectedProvincia) ? 'disabled' : '' ?>>
                        <option value="">Seleccione distrito</option>
                        <?php if (!empty($selectedProvincia)): ?>
                          <!-- Los distritos se cargarán por JavaScript -->
                        <?php endif; ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Corregimiento -->
              <div class="column is-one-third">
                <div class="field">
                  <label class="label">Corregimiento</label>
                  <div class="control">
                    <div class="select is-fullwidth">
                      <select id="corregimiento" name="corregimiento" <?= empty($selectedDistrito) ? 'disabled' : '' ?>>
                        <option value="">Seleccione corregimiento</option>
                        <?php if (!empty($selectedDistrito)): ?>
                          <!-- Los corregimientos se cargarán por JavaScript -->
                        <?php endif; ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="box">
      <h2 class="title is-4">Reclamos Registrados</h2>
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
              <th>Usuario</th>
              <th>Categoría</th>
              <th>Descripción</th>
              <th>Estado</th>
              <th>Fecha</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($reclamos)): ?>
              <?php foreach ($reclamos as $reclamo): ?>
                <tr>
                  <td><?= esc($reclamo['id']) ?></td>
                  <td><?= esc($reclamo['nombre'] ?? 'Desconocido') ?></td>
                  <td><?= esc($reclamo['nombre_categoria'] ?? 'Desconocido') ?></td>
                  <td><?= esc(substr($reclamo['descripcion'], 0, 70)) ?><?= (strlen($reclamo['descripcion']) > 70) ? '...' : '' ?></td>
                  <td>
                    <?php
                      $estadoClass = '';
                      switch ($reclamo['estado']) {
                        case 'pendiente':
                          $estadoClass = 'is-warning';
                          break;
                        case 'en_proceso':
                          $estadoClass = 'is-info';
                          break;
                        case 'solucionado':
                          $estadoClass = 'is-success';
                          break;
                      }
                    ?>
                    <span class="tag <?= $estadoClass ?>"><?= esc(ucfirst(str_replace('_', ' ', $reclamo['estado']))) ?></span>
                  </td>
                  <td><?= esc(date('d/m/Y H:i', strtotime($reclamo['fecha']))) ?></td>
                 <td>
                  <div class="buttons is-small">
                    <a class="button is-small is-light" title="Ver detalles" onclick="openReclamoModal(<?= $reclamo['id'] ?>)">
                      <span class="icon"><i class="fas fa-eye"></i></span>
                      <span>Ver</span>
                    </a>
                  </div>
                </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="has-text-centered">No hay reclamos registrados.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<!-- Modal para Responder Reclamo 
 
<div id="reply-modal" class="modal">
  <div class="modal-background"></div>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Responder Reclamo</p>
      <button class="delete" aria-label="close" onclick="closeModal()"></button>
    </header>
    <section class="modal-card-body">
      <form id="reply-form" action="<?= base_url('reclamos/update') ?>" method="post">
        <input type="hidden" name="reclamo_id" id="modal-reclamo-id">
        <div class="field">
          <label class="label" for="comentario">Comentario</label>
          <div class="control">
            <textarea class="textarea" name="comentario" id="comentario" placeholder="Escribe tu respuesta o comentario aquí..."></textarea>
          </div>
        </div>
        <div class="field">
          <label class="label" for="new_status">Cambiar Estado a:</label>
          <div class="control">
            <div class="select is-fullwidth">
              <select name="new_status" id="new_status">
                <option value="pendiente">Pendiente</option>
                <option value="en_proceso">En Proceso</option>
                <option value="solucionado">Solucionado</option>
              </select>
            </div>
          </div>
        </div>
      </form>
    </section>
    <footer class="modal-card-foot">
      <button class="button is-success is-light" type="submit" form="reply-form">Guardar Cambios</button>
      <button class="button is-light" onclick="closeModal()">Cancelar</button>
    </footer>
  </div>
</div> -->

<script>
  // Mostrar/ocultar filtros
document.getElementById('toggle-filters').addEventListener('click', function() {
    const filtersSection = document.getElementById('filters-section');
    const icon = this.querySelector('.icon i');
    
    if (filtersSection.style.display === 'none') {
        filtersSection.style.display = 'block';
        icon.classList.remove('fa-filter');
        icon.classList.add('fa-times');
        this.classList.add('is-active');
    } else {
        filtersSection.style.display = 'none';
        icon.classList.remove('fa-times');
        icon.classList.add('fa-filter');
        this.classList.remove('is-active');
    }
});

// Mostrar filtros si hay alguno seleccionado
document.addEventListener('DOMContentLoaded', function() {
    const selectedProvincia = '<?= $selectedProvincia ?? '' ?>';
    const selectedDistrito = '<?= $selectedDistrito ?? '' ?>';
    const selectedCorregimiento = '<?= $selectedCorregimiento ?? '' ?>';
    
    if (selectedProvincia || selectedDistrito || selectedCorregimiento) {
        document.getElementById('filters-section').style.display = 'block';
        const toggleBtn = document.getElementById('toggle-filters');
        toggleBtn.querySelector('.icon i').classList.remove('fa-filter');
        toggleBtn.querySelector('.icon i').classList.add('fa-times');
        toggleBtn.classList.add('is-active');
    }
});

// 1. Define una variable con la base URL
const BASE_URL = window.location.origin + '/reclamosSugerencias/public';

// 2. Función para cargar distritos
async function cargarDistritos(codigoProvincia, distritoSeleccionado = '') {
    const distritoSelect = document.getElementById('distrito');
    
    if (!codigoProvincia) {
        distritoSelect.innerHTML = '<option value="">Seleccione distrito</option>';
        distritoSelect.disabled = true;
        return;
    }

    distritoSelect.innerHTML = '<option value="">Cargando...</option>';
    
    try {
        const response = await fetch(`${BASE_URL}/api/distritos/${codigoProvincia}`);
        
        if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);
        
        const data = await response.json();
        
        distritoSelect.innerHTML = '<option value="">Seleccione distrito</option>';
        
        if (data.length > 0) {
            data.forEach(d => {
                const selected = d.codigo_distrito === distritoSeleccionado ? 'selected' : '';
                distritoSelect.innerHTML += `<option value="${d.codigo_distrito}" ${selected}>${d.nombre_distrito}</option>`;
            });
            distritoSelect.disabled = false;
        } else {
            distritoSelect.innerHTML = '<option value="">No hay distritos</option>';
        }
    } catch (error) {
        console.error("Error al cargar distritos:", error);
        distritoSelect.innerHTML = '<option value="">Error al cargar</option>';
    }
}

// 3. Función para cargar corregimientos
async function cargarCorregimientos(codigoProvincia, codigoDistrito, corregimientoSeleccionado = '') {
    const corregimientoSelect = document.getElementById('corregimiento');

    if (!codigoDistrito) {
        corregimientoSelect.innerHTML = '<option value="">Seleccione corregimiento</option>';
        corregimientoSelect.disabled = true;
        return;
    }

    corregimientoSelect.innerHTML = '<option value="">Cargando...</option>';
    
    try {
        const response = await fetch(`${BASE_URL}/api/corregimientos/${codigoProvincia}/${codigoDistrito}`);
        
        if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);
        
        const data = await response.json();
        
        corregimientoSelect.innerHTML = '<option value="">Seleccione corregimiento</option>';
        
        if (data.length > 0) {
            data.forEach(c => {
                const selected = c.codigo_corregimiento === corregimientoSeleccionado ? 'selected' : '';
                corregimientoSelect.innerHTML += `<option value="${c.codigo_corregimiento}" ${selected}>${c.nombre_corregimiento}</option>`;
            });
            corregimientoSelect.disabled = false;
        } else {
            corregimientoSelect.innerHTML = '<option value="">No hay corregimientos</option>';
        }
    } catch (error) {
        console.error("Error al cargar corregimientos:", error);
        corregimientoSelect.innerHTML = '<option value="">Error al cargar</option>';
    }
}

// 4. Event Listeners
document.getElementById('provincia').addEventListener('change', function() {
    const codigoProvincia = this.value;
    cargarDistritos(codigoProvincia);
    // Resetear corregimiento cuando cambia la provincia
    document.getElementById('corregimiento').innerHTML = '<option value="">Seleccione corregimiento</option>';
    document.getElementById('corregimiento').disabled = true;
});

document.getElementById('distrito').addEventListener('change', function() {
    const codigoProvincia = document.getElementById('provincia').value;
    const codigoDistrito = this.value;
    cargarCorregimientos(codigoProvincia, codigoDistrito);
});

// 5. Cargar valores iniciales si existen
document.addEventListener('DOMContentLoaded', function() {
    const provinciaSelect = document.getElementById('provincia');
    const selectedProvincia = '<?= $selectedProvincia ?? '' ?>';
    const selectedDistrito = '<?= $selectedDistrito ?? '' ?>';
    const selectedCorregimiento = '<?= $selectedCorregimiento ?? '' ?>';
    
    if (selectedProvincia) {
        provinciaSelect.value = selectedProvincia;
        cargarDistritos(selectedProvincia, selectedDistrito).then(() => {
            if (selectedDistrito) {
                const distritoSelect = document.getElementById('distrito');
                distritoSelect.value = selectedDistrito;
                cargarCorregimientos(selectedProvincia, selectedDistrito, selectedCorregimiento);
            }
        });
    }
});

function updateStatusInTable(reclamoId, newStatus) {
    // Buscar la fila correspondiente en la tabla
    const rows = document.querySelectorAll('.table tbody tr');
    
    rows.forEach(row => {
        const rowId = row.querySelector('td:first-child').textContent;
        if (rowId === reclamoId.toString()) {
            // Encontré la fila que necesito actualizar
            const statusCell = row.querySelector('td:nth-child(5)'); // Ajusta este selector según tu estructura
            
            // Limpiar y actualizar el tag de estado
            statusCell.innerHTML = '';
            const tag = document.createElement('span');
            tag.className = `tag ${getStatusClass(newStatus)}`;
            tag.textContent = newStatus.replace('_', ' ');
            statusCell.appendChild(tag);
            
            // También puedes actualizar otros datos si es necesario
            const fechaActualizacion = row.querySelector('td:nth-child(6)'); // Ajusta según tu estructura
            if (fechaActualizacion) {
                fechaActualizacion.textContent = new Date().toLocaleString();
            }
        }
    });
    
    // Actualizar contadores en el sidebar si existen
    updateStatusCounters();
}


  function openReplyModal(reclamoId, currentStatus) {
    document.getElementById('modal-reclamo-id').value = reclamoId;
    document.getElementById('comentario').value = ''; // Limpiar comentario anterior
    document.getElementById('new_status').value = currentStatus; // Establecer el estado actual
    document.getElementById('reply-modal').classList.add('is-active');
  }

  function closeModal() {
    document.getElementById('reply-modal').classList.remove('is-active');
  }

  // Event listener para el botón de cerrar en el encabezado del modal
  document.querySelector('#reply-modal .delete').addEventListener('click', closeModal);
</script>
<?= $this->endSection() ?>
