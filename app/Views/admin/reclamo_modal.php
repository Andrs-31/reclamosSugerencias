<div id="reclamo-modal" class="modal">
  <div class="modal-background"></div>
  <div class="modal-card" style="width: 80%; max-width: 800px;">
    <header class="modal-card-head">
      <p class="modal-card-title">Detalles del Reclamo #<span id="modal-reclamo-id"></span></p>
      <button class="delete" aria-label="close" onclick="closeReclamoModal()"></button>
    </header>
    <section class="modal-card-body">
      <div class="columns">
        <!-- Columna izquierda: Información del reclamo -->
        <div class="column is-6">
          <div class="content">
            <h4 class="title is-4">Información del Reclamo</h4>
            <div class="box">
              <!-- Campos de información básica -->
              <div class="field is-horizontal">
                <div class="field-label"><label class="label">Usuario:</label></div>
                <div class="field-body"><p class="control" id="modal-usuario"></p></div>
              </div>
              
              <div class="field is-horizontal">
                <div class="field-label"><label class="label">Categoría:</label></div>
                <div class="field-body"><p class="control" id="modal-categoria"></p></div>
              </div>
              
              <div class="field is-horizontal">
                <div class="field-label"><label class="label">Estado:</label></div>
                <div class="field-body"><p class="control" id="modal-estado"></p></div>
              </div>
              
              <div class="field is-horizontal">
                <div class="field-label"><label class="label">Fecha:</label></div>
                <div class="field-body"><p class="control" id="modal-fecha"></p></div>
              </div>
              
              <div class="field is-horizontal">
                <div class="field-label"><label class="label">Ubicación:</label></div>
                <div class="field-body"><p class="control" id="modal-direccion"></p></div>
              </div>
              
              <!-- Descripción -->
              <div class="field">
                <label class="label">Descripción:</label>
                <div class="content box" id="modal-descripcion" style="white-space: pre-line;"></div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Columna derecha: Comentarios y respuesta -->
        <div class="column is-6">
          <div class="content">
            <h4 class="title is-4">Comentarios</h4>
            <div class="box" style="max-height: 300px; overflow-y: auto;" id="comentarios-container">
              <div class="has-text-centered py-5">
                <span class="icon is-large">
                  <i class="fas fa-spinner fa-pulse"></i>
                </span>
                <p>Cargando comentarios...</p>
              </div>
            </div>
            
          <form id="reply-form" onsubmit="enviarComentario(event)">
    <input type="hidden" name="reclamo_id" id="modal-reclamo-id-input">
    
    <div class="field">
        <label class="label">Nuevo Comentario</label>
        <div class="control">
            <textarea class="textarea" name="comentario" id="comentario" 
                placeholder="Escribe tu respuesta o comentario aquí..." rows="3" required></textarea>
        </div>
    </div>
    
    <div class="field is-horizontal">
        <div class="field-label">
            <label class="label">Cambiar Estado:</label>
        </div>
        <div class="field-body">
            <div class="field">
                <div class="select is-fullwidth">
                    <select name="new_status" id="new_status">
                        <option value="pendiente">Pendiente</option>
                        <option value="en_proceso">En Proceso</option>
                        <option value="solucionado">Solucionado</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    
    <div class="field">
        <div class="control">
            <button type="submit" class="button is-primary is-fullwidth">
                <span class="icon">
                    <i class="fas fa-paper-plane"></i>
                </span>
                <span id="submit-text">Enviar Respuesta</span>
                <span class="icon is-hidden" id="submit-loading">
                    <i class="fas fa-spinner fa-pulse"></i>
                </span>
            </button>
        </div>
    </div>
</form>
    </section>
    <footer class="modal-card-foot">
      <button class="button is-light" onclick="closeReclamoModal()">Cerrar</button>
    </footer>
  </div>
</div>

<script>
// 1. Definir funciones auxiliares primero
function getStatusClass(estado) {
    switch (estado) {
        case 'pendiente': return 'is-warning';
        case 'en_proceso': return 'is-info';
        case 'solucionado': return 'is-success';
        default: return '';
    }
}

function closeReclamoModal() {
    const modal = document.getElementById('reclamo-modal');
    if (modal) {
        modal.classList.remove('is-active');
    }
}

function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification is-${type}`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// 2. Configuración inicial del modal
document.addEventListener('DOMContentLoaded', function() {
    // Configuración del menú móvil
    const mobileToggle = document.getElementById('mobile-menu-toggle');
    const sidebar = document.querySelector('.sidebar-fixed');
    
    if (mobileToggle && sidebar) {
        if (window.innerWidth <= 768) {
            mobileToggle.style.display = 'block';
        }
        
        mobileToggle.addEventListener('click', () => {
            sidebar.classList.toggle('is-active');
        });
        
        document.addEventListener('click', (e) => {
            if (window.innerWidth <= 768 && 
                !sidebar.contains(e.target) && 
                !mobileToggle.contains(e.target)) {
                sidebar.classList.remove('is-active');
            }
        });
    }
    
    window.addEventListener('resize', () => {
        if (mobileToggle) {
            mobileToggle.style.display = window.innerWidth <= 768 ? 'block' : 'none';
        }
        if (sidebar && window.innerWidth > 768) {
            sidebar.classList.remove('is-active');
        }
    });
});

// 3. Funciones del modal
async function openReclamoModal(reclamoId) {
    try {
        const modal = document.getElementById('reclamo-modal');
        if (!modal) {
            console.error('Modal element not found');
            return;
        }
        
        modal.classList.add('is-active');
        
        const response = await fetch(`${BASE_URL}/api/reclamos/${reclamoId}`);
        if (!response.ok) throw new Error('Error al cargar el reclamo');
        
        const reclamo = await response.json();
        
        // Llenar datos del reclamo
        document.getElementById('modal-reclamo-id').textContent = reclamo.id;
        document.getElementById('modal-reclamo-id-input').value = reclamo.id;
        //document.getElementById('modal-usuario').textContent = reclamo.nombre_usuario || 'Desconocido';
        document.getElementById('modal-usuario').textContent = reclamo.nombre || 'Desconocido';
        document.getElementById('modal-categoria').textContent = reclamo.nombre_categoria || 'Desconocido';
        document.getElementById('modal-descripcion').textContent = reclamo.descripcion;
        document.getElementById('modal-fecha').textContent = new Date(reclamo.fecha).toLocaleString();
        document.getElementById('modal-direccion').textContent = reclamo.direccion_completa || 'Dirección no disponible';
        
        // Estado actual
        const statusSelect = document.getElementById('new_status');
        if (statusSelect) {
            statusSelect.value = reclamo.estado;
        }
        
        // Tag de estado
        const estadoTag = document.getElementById('modal-estado');
        if (estadoTag) {
            estadoTag.innerHTML = '';
            const tag = document.createElement('span');
            tag.className = `tag ${getStatusClass(reclamo.estado)}`;
            tag.textContent = reclamo.estado.replace('_', ' ');
            estadoTag.appendChild(tag);
        }
        
        // Cargar comentarios
        await loadComentarios(reclamoId);
        
    } catch (error) {
        console.error('Error:', error);
        showNotification('Error al cargar los detalles del reclamo', 'danger');
        closeReclamoModal();
    }
}

async function loadComentarios(reclamoId) {
    const container = document.getElementById('comentarios-container');
    if (!container) return;
    
    try {
        container.innerHTML = '<div class="has-text-centered py-5"><span class="icon is-large"><i class="fas fa-spinner fa-pulse"></i></span><p>Cargando comentarios...</p></div>';
        
        const response = await fetch(`${BASE_URL}/api/reclamos/${reclamoId}/comentarios`);
        if (!response.ok) throw new Error('Error al cargar comentarios');
        
        const comentarios = await response.json();
        
        if (comentarios.length === 0) {
            container.innerHTML = '<div class="notification is-light">No hay comentarios aún.</div>';
            return;
        }
        
        let html = '';
        comentarios.forEach(comentario => {
            const fecha = new Date(comentario.fecha).toLocaleString();
            html += `
                <article class="media">
                    <div class="media-content">
                        <div class="content">
                            <p>
                                <strong>${comentario.autor || 'Sistema'}</strong> <small>${fecha}</small>
                                <br>
                                ${comentario.comentario}
                            </p>
                        </div>
                    </div>
                </article>
                <hr class="is-marginless">
            `;
        });
        
        container.innerHTML = html;
    } catch (error) {
        console.error('Error al cargar comentarios:', error);
        container.innerHTML = '<div class="notification is-danger">Error al cargar los comentarios.</div>';
    }
}
let isSubmitting = false; // Variable global para controlar el estado

async function enviarComentario(event) {
    event.preventDefault();
    
    if (isSubmitting) {
        return;
    }
    
    const form = event.target;
    const reclamoId = document.getElementById('modal-reclamo-id-input').value;
    const comentario = form.querySelector('[name="comentario"]').value.trim();
    const newStatus = form.querySelector('[name="new_status"]').value;
    const submitButton = form.querySelector('button[type="submit"]');
    
    // Validación básica en el cliente
    if (!comentario || comentario.length < 5) {
        showNotification('El comentario debe tener al menos 5 caracteres', 'danger');
        return;
    }

    try {
        isSubmitting = true;
        submitButton.disabled = true;
        submitButton.classList.add('is-loading');
        
        
        const response = await fetch(`${BASE_URL}/api/reclamos/comentarios`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                reclamo_id: reclamoId,
                comentario: comentario,
                new_status: newStatus
            })
        });
        
        const result = await response.json();
        
        if (!response.ok) {
            console.error('Error del servidor:', result);
            throw new Error(result.error || 'Error en el servidor');
        }
        
        
        // Actualizar el estado en el modal
        const estadoTag = document.getElementById('modal-estado');
        if (estadoTag) {
            estadoTag.innerHTML = '';
            const tag = document.createElement('span');
            tag.className = `tag ${getStatusClass(newStatus)}`;
            tag.textContent = newStatus.replace('_', ' ');
            estadoTag.appendChild(tag);
        }
        
        // Actualizar el estado en la tabla principal
        updateStatusInTable(reclamoId, newStatus);
        
        // Recargar comentarios y limpiar formulario
        await loadComentarios(reclamoId);
        form.querySelector('textarea').value = '';
        
    } catch (error) {
        console.error('Error completo:', error);

    } finally {
        isSubmitting = false;
        submitButton.disabled = false;
        submitButton.classList.remove('is-loading');
    }
}

// 4. Asignar event listeners cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    const replyForm = document.getElementById('reply-form');
    if (replyForm) {
        replyForm.addEventListener('submit', enviarComentario);
    }
    
    // Asignar función de cierre a los botones
    const closeButtons = document.querySelectorAll('[onclick="closeReclamoModal()"]');
    closeButtons.forEach(button => {
        button.onclick = closeReclamoModal;
    });
});
</script>