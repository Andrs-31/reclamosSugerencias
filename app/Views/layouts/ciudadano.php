
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= esc($titulo ?? 'Panel de Administración') ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <style>
    .main-content {
      margin-left: 220px; /* mismo ancho del navbar */
      padding: 1.5rem;
    }

    @media screen and (max-width: 768px) {
      .main-content {
        margin-left: 0;
      }
    }
  </style>
</head>
<body>
  <?= view('componentes/navbarVerAdmin') ?>

  <div class="main-content">
    <section class="section">
      <div class="container">
        <?= $this->renderSection('contenido') ?>
      </div>
    </section>
  </div>
  <div class="main-content">
    <section class="section">
      <div class="container">
        <?= $this->renderSection('imagen') ?>
      </div>
    </section>
  </div>
</body>
</html>
