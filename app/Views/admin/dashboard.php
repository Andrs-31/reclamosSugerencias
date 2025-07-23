<?= $this->extend('layouts/admin') ?>

<?= $this->section('contenido') ?>
<div class="hero is-link is-small">
  <div class="hero-body">
    <div class="container">
      <h1 class="title is-2 has-text-white">
        <span class="icon is-large">
          <i class="fas fa-tachometer-alt"></i>
        </span>
        Panel de Administración
      </h1>
      <p class="subtitle is-4 has-text-white">
        Gestión de Reclamos y Sugerencias Ciudadanas
      </p>
    </div>
  </div>
</div>

<!-- Estadísticas principales -->
<section class="section">
  <div class="container">
    <div class="columns is-multiline">
      <!-- Tarjeta de Reclamos Totales -->
      <div class="column is-4">
        <div class="card has-background-info-light">
          <div class="card-content has-text-centered">
            <div class="content">
              <span class="icon is-large has-text-info">
                <i class="fas fa-clipboard-list fa-2x"></i>
              </span>
              <p class="title is-1 has-text-info"><?= esc($totalReclamos ?? 0) ?></p>
              <p class="subtitle is-5 has-text-grey-dark">Reclamos Totales</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Tarjeta de Pendientes -->
      <div class="column is-4">
        <div class="card has-background-warning-light">
          <div class="card-content has-text-centered">
            <div class="content">
              <span class="icon is-large has-text-warning">
                <i class="fas fa-clock fa-2x"></i>
              </span>
              <p class="title is-1 has-text-warning"><?= esc($reclamosPendientes ?? 0) ?></p>
              <p class="subtitle is-5 has-text-grey-dark">Pendientes</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Tarjeta de Solucionados -->
      <div class="column is-4">
        <div class="card has-background-success-light">
          <div class="card-content has-text-centered">
            <div class="content">
              <span class="icon is-large has-text-success">
                <i class="fas fa-check-circle fa-2x"></i>
              </span>
              <p class="title is-1 has-text-success"><?= esc($reclamosSolucionados ?? 0) ?></p>
              <p class="subtitle is-5 has-text-grey-dark">Solucionados</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Gráficas -->
<section class="section">
  <div class="container">
    <div class="columns is-multiline">
      <!-- Gráfica de reclamos por categoría -->
      <div class="column is-6">
        <div class="card">
          <header class="card-header">
            <p class="card-header-title">
              <span class="icon">
                <i class="fas fa-chart-bar"></i>
              </span>
              Reclamos por Categoría
            </p>
          </header>
          <div class="card-content">
            <canvas id="chartCategoria" style="height: 300px;"></canvas>
          </div>
        </div>
      </div>

      <!-- Gráfica de reclamos por estado -->
      <div class="column is-6">
        <div class="card">
          <header class="card-header">
            <p class="card-header-title">
              <span class="icon">
                <i class="fas fa-chart-pie"></i>
              </span>
              Reclamos por Estado
            </p>
          </header>
          <div class="card-content">
            <canvas id="chartEstado" style="height: 300px;"></canvas>
          </div>
        </div>
      </div>

      <!-- Nueva Gráfica de reclamos por provincia -->
      <div class="column is-12">
        <div class="card">
          <header class="card-header">
            <p class="card-header-title">
              <span class="icon">
                <i class="fas fa-map-marked-alt"></i>
              </span>
              Reclamos por Provincia
            </p>
          </header>
          <div class="card-content">
            <canvas id="chartProvincia" style="height: 400px;"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Acciones rápidas -->
<section class="section">
  <div class="container">
    <div class="card">
      <header class="card-header">
        <p class="card-header-title">
          <span class="icon">
            <i class="fas fa-bolt"></i>
          </span>
          Acciones Rápidas
        </p>
      </header>
      <div class="card-content">
        <div class="columns">
          <div class="column">
            <a href="<?= base_url('reclamos') ?>" class="button is-primary is-fullwidth is-large">
              <span class="icon">
                <i class="fas fa-list"></i>
              </span>
              <span>Ver Todos los Reclamos</span>
            </a>
          </div>
          <div class="column">
            <a href="<?= base_url('reclamos/pendiente') ?>" class="button is-warning is-fullwidth is-large">
              <span class="icon">
                <i class="fas fa-exclamation-triangle"></i>
              </span>
              <span>Reclamos Pendientes</span>
            </a>
          </div>
          <div class="column">
           <a href="http://localhost/webConsumo/Reclamos_api.html" target="_blank" rel="noopener noreferrer" class="button is-info is-fullwidth is-large">
              <span class="icon">
                <i class="fas fa-chart-line"></i>
              </span>
              <span>Ver reportes Públicos</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Chart.js y Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

const ctxCategoria = document.getElementById('chartCategoria').getContext('2d');

// Preparar datos para la gráfica
const categorias = <?= json_encode(array_column($reclamosPorCategoria, 'categoria')) ?>;
const reclamosXCategoria = <?= json_encode(array_column($reclamosPorCategoria, 'total')) ?>;

new Chart(ctxCategoria, {
    type: 'bar',
    data: {
        labels: categorias,
        datasets: [{
            label: 'Cantidad de Reclamos',
            data: reclamosXCategoria,
            backgroundColor: [
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(255, 99, 132, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0,0,0,0.1)'
                }
            },
            y: {
                grid: {
                    color: 'rgba(0,0,0,0.1)'
                }
            }
        },
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                backgroundColor: 'rgba(0,0,0,0.8)',
                titleColor: 'white',
                bodyColor: 'white'
            }
        }
    }
});
  // Reclamos por Estado - Barra Vertical
  const ctxEstado = document.getElementById('chartEstado').getContext('2d');
  new Chart(ctxEstado, {
    type: 'doughnut',
    data: {
      labels: ['Pendiente', 'En Proceso', 'Solucionado'],
      datasets: [{
        label: 'Cantidad',
        data: [<?= esc($reclamosPendientes ?? 0) ?>, <?= esc($reclamosEnProceso ?? 0) ?>, <?= esc($reclamosSolucionados ?? 0) ?>], // Datos dinámicos
        backgroundColor: [
          'rgba(255, 159, 64, 0.8)',
          'rgba(153, 102, 255, 0.8)',
          'rgba(75, 192, 192, 0.8)'
        ],
        borderColor: [
          'rgba(255, 159, 64, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(75, 192, 192, 1)'
        ],
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            padding: 20,
            usePointStyle: true
          }
        },
        tooltip: {
          backgroundColor: 'rgba(0,0,0,0.8)',
          titleColor: 'white',
          bodyColor: 'white'
        }
      }
    }
  });
  const ctxProvincia = document.getElementById('chartProvincia').getContext('2d');
  
  // Preparar datos para la gráfica
  <?php
    $provincias = [];
    $totales = [];
    foreach ($reclamosPorProvincia as $item) {
      $provincias[] = $item['nombre_provincia'];
      $totales[] = $item['total'];
    }
  ?>
  new Chart(ctxProvincia, {
    type: 'bar',
    data: {
      labels: <?= json_encode($provincias) ?>,
      datasets: [{
        label: 'Cantidad de Reclamos',
        data: <?= json_encode($totales) ?>,
        backgroundColor: [
          'rgba(54, 162, 235, 0.7)',
          'rgba(255, 99, 132, 0.7)',
          'rgba(255, 206, 86, 0.7)',
          'rgba(75, 192, 192, 0.7)',
          'rgba(153, 102, 255, 0.7)',
          'rgba(255, 159, 64, 0.7)',
          'rgba(199, 199, 199, 0.7)',
          'rgba(83, 102, 255, 0.7)',
          'rgba(40, 159, 64, 0.7)',
          'rgba(210, 99, 132, 0.7)'
        ],
        borderColor: [
          'rgba(54, 162, 235, 1)',
          'rgba(255, 99, 132, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)',
          'rgba(199, 199, 199, 1)',
          'rgba(83, 102, 255, 1)',
          'rgba(40, 159, 64, 1)',
          'rgba(210, 99, 132, 1)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true,
          grid: {
            color: 'rgba(0,0,0,0.1)'
          },
          ticks: {
            stepSize: 1
          }
        },
        x: {
          grid: {
            display: false
          }
        }
      },
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          backgroundColor: 'rgba(0,0,0,0.8)',
          titleColor: 'white',
          bodyColor: 'white',
          callbacks: {
            label: function(context) {
              return `${context.parsed.y} reclamos`;
            }
          }
        }
      }
    }
  });
</script>
<?= $this->endSection() ?>
