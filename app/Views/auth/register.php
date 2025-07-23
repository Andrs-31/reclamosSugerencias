<!--MODIFICADO POR JAFETH J -->

<!-- LLamamos al template del login -->
<?= $this->extend('layouts/template_login'); ?>
<!-- Definimos la sección de contenido -->
<?= $this->section('content'); ?>
<div class="container py-5">
  <div class="card shadow-lg border-0 mx-auto" style="max-width: 900px;">
    <div class="row g-0">
      <!-- Columna izquierda -->
      <div class="col-md-5 bg-primary text-white d-flex flex-column justify-content-center align-items-center p-4">
        <h2 class="fw-bold">¡Bienvenido!</h2>
        <p class="text-center mb-4">
          Regístrate para acceder a la plataforma de Reclamos y Sugerencias.<br>
          ¿Ya tienes cuenta?
        </p>
        <a href="<?= base_url('login') ?>" class="btn btn-outline-light w-100">Iniciar sesión</a>
      </div>

      <!-- Columna derecha -->
      <div class="col-md-7 bg-white p-4">
        <h3 class="card-title fw-bold mb-4 text-primary text-center">Registro</h3>
        <form method="POST" action="<?= base_url('register'); ?>" autocomplete="off">
          <?= csrf_field(); ?>

          <!-- Datos personales -->
          <div class="row">
            <div class="col-md-12 mb-3">
              <label for="name" class="form-label">Nombre Completo</label>
              <input type="text" class="form-control" name="name" id="name"
                     placeholder="Nombre Apellido" value="<?= set_value('name') ?>" required autofocus>
            </div>

            <div class="col-md-6 mb-3">
              <label for="user" class="form-label">Usuario</label>
              <input type="text" class="form-control" name="user" id="user"
                     placeholder="usuario" value="<?= set_value('user') ?>" required>
            </div>

            <div class="col-md-6 mb-3">
              <label for="email" class="form-label">Correo electrónico</label>
              <input type="email" class="form-control" name="email" id="email"
                     value="<?= set_value('email') ?>" required>
            </div>

            <div class="col-md-6 mb-3">
              <label for="password" class="form-label">Contraseña</label>
              <input type="password" class="form-control" name="password" id="password" required>
            </div>

            <div class="col-md-6 mb-3">
              <label for="repassword" class="form-label">Confirmar contraseña</label>
              <input type="password" class="form-control" name="repassword" id="repassword" required>
            </div>
          </div>

          <hr class="my-4">

          <!-- Dirección -->
          <div class="row ubicacion-selects">
            <div class="col-md-4 mb-3">
              <label for="provincia" class="form-label">Provincia</label>
              <select class="form-select" name="provincia" id="provincia" required>
                <option value="">Seleccione provincia</option>
                <?php foreach($provincias as $prov): ?>
                  <option value="<?= $prov['codigo_provincia'] ?>" 
                    <?= ($prov['codigo_provincia'] == ($selectedProvincia ?? '')) ? 'selected' : '' ?>>
                    <?= $prov['nombre_provincia'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-4 mb-3">
              <label for="distrito" class="form-label">Distrito</label>
              <select class="form-select" id="distrito" name="distrito" <?= empty($selectedProvincia) ? 'disabled' : '' ?>>
                <option value="">Seleccione distrito</option>
              </select>
            </div>

            <div class="col-md-4 mb-3">
              <label for="corregimiento" class="form-label">Corregimiento</label>
              <select class="form-select" id="corregimiento" name="corregimiento" <?= empty($selectedDistrito) ? 'disabled' : '' ?>>
                <option value="">Seleccione corregimiento</option>
              </select>
            </div>
          </div>

          <button type="submit" class="btn btn-primary w-100 mt-2">Registrar</button>

          <?php if (isset($validation)): ?>
            <div class="alert alert-danger mt-3">
              <?= $validation->listErrors(); ?>
            </div>
          <?php endif; ?>
        </form>
      </div>
    </div>
  </div>
</div>
</div>


<script>
    //------------SCRIPT DE UBICACION
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
</script>

<?= $this->endsection(); ?>

<!--MODIFICADO POR JAFETH J -->