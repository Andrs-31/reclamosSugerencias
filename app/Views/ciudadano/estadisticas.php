<?= $this->extend('layouts/ciudadano') ?>
<?= $this->section('content') ?>
  <h1 class="title">Estadísticas de Mis Reclamos</h1>
  
  <div class="columns">
    <div class="column is-12">
      <!-- Tarjetas de estadísticas -->
      <div class="columns">
        <div class="column is-4">
          <div class="box has-text-centered">
            <div class="heading">
              <span class="icon is-large has-text-warning">
                <i class="fas fa-clock fa-2x"></i>
              </span>
            </div>
            <h2 class="title is-1 has-text-warning"><?= $estadisticas['pendientes'] ?></h2>
            <p class="subtitle is-4">Pendientes</p>
            <p class="has-text-grey">Reclamos esperando atención</p>
          </div>
        </div>
        
        <div class="column is-4">
          <div class="box has-text-centered">
            <div class="heading">
              <span class="icon is-large has-text-info">
                <i class="fas fa-cogs fa-2x"></i>
              </span>
            </div>
            <h2 class="title is-1 has-text-info"><?= $estadisticas['en_proceso'] ?></h2>
            <p class="subtitle is-4">En Proceso</p>
            <p class="has-text-grey">Reclamos siendo atendidos</p>
          </div>
        </div>
        
        <div class="column is-4">
          <div class="box has-text-centered">
            <div class="heading">
              <span class="icon is-large has-text-success">
                <i class="fas fa-check-circle fa-2x"></i>
              </span>
            </div>
            <h2 class="title is-1 has-text-success"><?= $estadisticas['solucionados'] ?></h2>
            <p class="subtitle is-4">Solucionados</p>
            <p class="has-text-grey">Reclamos completados</p>
          </div>
        </div>
      </div>
      
      <!-- Tarjeta de total -->
      <div class="columns">
        <div class="column is-6 is-offset-3">
          <div class="box has-text-centered has-background-primary">
            <div class="heading">
              <span class="icon is-large has-text-white">
                <i class="fas fa-list fa-2x"></i>
              </span>
            </div>
            <h2 class="title is-1 has-text-white"><?= $estadisticas['total'] ?></h2>
            <p class="subtitle is-4 has-text-white">Total de Reclamos</p>
            <p class="has-text-white-bis">Todos tus reclamos registrados</p>
          </div>
        </div>
      </div>
      
      <!-- Gráfico de progreso -->
      <?php if ($estadisticas['total'] > 0): ?>
        <div class="box">
          <h3 class="title is-4">Progreso de Resolución</h3>
          <div class="content">
            <!-- Barra de progreso pendientes -->
            <div class="field">
              <label class="label">Pendientes (<?= round(($estadisticas['pendientes'] / $estadisticas['total']) * 100, 1) ?>%)</label>
              <progress class="progress is-warning" value="<?= $estadisticas['pendientes'] ?>" max="<?= $estadisticas['total'] ?>">
                <?= round(($estadisticas['pendientes'] / $estadisticas['total']) * 100, 1) ?>%
              </progress>
            </div>
            
            <!-- Barra de progreso en proceso -->
            <div class="field">
              <label class="label">En Proceso (<?= round(($estadisticas['en_proceso'] / $estadisticas['total']) * 100, 1) ?>%)</label>
              <progress class="progress is-info" value="<?= $estadisticas['en_proceso'] ?>" max="<?= $estadisticas['total'] ?>">
                <?= round(($estadisticas['en_proceso'] / $estadisticas['total']) * 100, 1) ?>%
              </progress>
            </div>
            
            <!-- Barra de progreso solucionados -->
            <div class="field">
              <label class="label">Solucionados (<?= round(($estadisticas['solucionados'] / $estadisticas['total']) * 100, 1) ?>%)</label>
              <progress class="progress is-success" value="<?= $estadisticas['solucionados'] ?>" max="<?= $estadisticas['total'] ?>">
                <?= round(($estadisticas['solucionados'] / $estadisticas['total']) * 100, 1) ?>%
              </progress>
            </div>
          </div>
        </div>
      <?php endif; ?>
      
      <!-- Estadísticas adicionales -->
      <div class="columns">
        <div class="column is-6">
          <div class="box">
            <h4 class="title is-5">Resumen</h4>
            <div class="content">
              <?php if ($estadisticas['total'] > 0): ?>
                <ul>
                  <li><strong>Tasa de resolución:</strong> 
                    <?= round(($estadisticas['solucionados'] / $estadisticas['total']) * 100, 1) ?>%
                  </li>
                  <li><strong>Reclamos activos:</strong> 
                    <?= $estadisticas['pendientes'] + $estadisticas['en_proceso'] ?>
                  </li>
                  <li><strong>Estado más común:</strong> 
                    <?php 
                      $max = max($estadisticas['pendientes'], $estadisticas['en_proceso'], $estadisticas['solucionados']);
                      if ($max == $estadisticas['pendientes']) echo 'Pendiente';
                      elseif ($max == $estadisticas['en_proceso']) echo 'En Proceso';
                      else echo 'Solucionado';
                    ?>
                  </li>
                </ul>
              <?php else: ?>
                <p class="has-text-grey">No tienes reclamos registrados aún.</p>
              <?php endif; ?>
            </div>
          </div>
        </div>
        
        <div class="column is-6">
          <div class="box">
            <h4 class="title is-5">Acciones Rápidas</h4>
            <div class="content">
              <div class="buttons">
                <a href="/reclamosSugerencias/public/ciudadano/nuevo-reclamo" class="button is-primary">
                  <span class="icon">
                    <i class="fas fa-plus"></i>
                  </span>
                  <span>Nuevo Reclamo</span>
                </a>
                
                <a href="/reclamosSugerencias/public/ciudadano/mis-reclamos" class="button is-info">
                  <span class="icon">
                    <i class="fas fa-list"></i>
                  </span>
                  <span>Ver Todos</span>
                </a>
                
                <?php if ($estadisticas['pendientes'] > 0): ?>
                  <a href="/reclamosSugerencias/public/ciudadano/mis-reclamos?filtro=pendiente" class="button is-warning">
                    <span class="icon">
                      <i class="fas fa-clock"></i>
                    </span>
                    <span>Ver Pendientes</span>
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Mensaje motivacional -->
      <?php if ($estadisticas['total'] > 0): ?>
        <div class="notification <?= $estadisticas['solucionados'] == $estadisticas['total'] ? 'is-success' : 'is-info' ?>">
          <?php if ($estadisticas['solucionados'] == $estadisticas['total']): ?>
            <p><strong>¡Felicitaciones!</strong> Todos tus reclamos han sido solucionados.</p>
          <?php elseif ($estadisticas['solucionados'] > 0): ?>
            <p><strong>¡Buen progreso!</strong> Ya tienes <?= $estadisticas['solucionados'] ?> reclamo<?= $estadisticas['solucionados'] > 1 ? 's' : '' ?> solucionado<?= $estadisticas['solucionados'] > 1 ? 's' : '' ?>.</p>
          <?php else: ?>
            <p><strong>Estamos trabajando en tus reclamos.</strong> Te notificaremos cuando tengamos actualizaciones.</p>
          <?php endif; ?>
        </div>
      <?php endif; ?>
      
    </div>
  </div>
<?= $this->endSection() ?>
