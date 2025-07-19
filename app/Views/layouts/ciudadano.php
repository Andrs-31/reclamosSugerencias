
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= esc($titulo ?? 'Panel de Ciudadano') ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    .main-content {
      padding: 1.5rem;
    }
  </style>
</head>
<body>
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
