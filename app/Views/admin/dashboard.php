<?= $this->extend('layouts/admin') ?>

<?= $this->section('contenido') ?>
<h1 class="title">Bienvenido al Panel de Administración</h1>

<div class="columns is-multiline">
  <!-- Tarjetas de resumen -->
  <div class="column is-4">
    <div class="box has-background-primary-light has-text-centered">
      <p class="title is-4">120</p>
      <p class="subtitle is-6">Reclamos Totales</p>
    </div>
  </div>
  <div class="column is-4">
    <div class="box has-background-warning-light has-text-centered">
      <p class="title is-4">45</p>
      <p class="subtitle is-6">Pendientes</p>
    </div>
  </div>
  <div class="column is-4">
    <div class="box has-background-success-light has-text-centered">
      <p class="title is-4">75</p>
      <p class="subtitle is-6">Solucionados</p>
    </div>
  </div>

  <!-- Gráfica de reclamos por categoría (Barra Horizontal) -->
  <div class="column is-6">
    <div class="box">
      <h2 class="subtitle">Reclamos por Categoría</h2>
      <canvas id="chartCategoria"></canvas>
    </div>
  </div>

  <!-- Gráfica de reclamos por estado (Barra Vertical) -->
  <div class="column is-6">
    <div class="box">
      <h2 class="subtitle">Reclamos por Estado</h2>
      <canvas id="chartEstado"></canvas>
    </div>
  </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Reclamos por Categoría - Barra Horizontal
  const ctxCategoria = document.getElementById('chartCategoria').getContext('2d');
  new Chart(ctxCategoria, {
    type: 'bar',
    data: {
      labels: ['Agua', 'Luz', 'Basura'],
      datasets: [{
        label: 'Cantidad',
        data: [40, 30, 50],
        backgroundColor: [
          'rgba(54, 162, 235, 0.7)',
          'rgba(255, 206, 86, 0.7)',
          'rgba(255, 99, 132, 0.7)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      indexAxis: 'y', // Barra horizontal
      scales: {
        x: {
          beginAtZero: true
        }
      },
      plugins: {
        legend: { display: false },
        title: {
          display: false
        }
      }
    }
  });

  // Reclamos por Estado - Barra Vertical
  const ctxEstado = document.getElementById('chartEstado').getContext('2d');
  new Chart(ctxEstado, {
    type: 'bar',
    data: {
      labels: ['Pendiente', 'En Proceso', 'Solucionado'],
      datasets: [{
        label: 'Cantidad',
        data: [45, 20, 55],
        backgroundColor: [
          'rgba(255, 159, 64, 0.7)',
          'rgba(153, 102, 255, 0.7)',
          'rgba(75, 192, 192, 0.7)'
        ],
        borderWidth: 1
      }]
    },
    options: {
      indexAxis: 'x',
      scales: {
        y: {
          beginAtZero: true
        }
      },
      plugins: {
        legend: { display: false },
        title: {
          display: false
        }
      }
    }
  });
</script>
<?= $this->endSection() ?>
