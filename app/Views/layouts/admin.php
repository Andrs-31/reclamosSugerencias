//Layout que contiene la estructura basica de las vistas del admin
//se peude agrear estilos y scripts comunes
//Para entender el funcionamiento ver el video del curso mandado al grupo "View Layouts"


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title><?= esc($titulo ?? 'Panel de Administración') ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
</head>
<body>
  <?= view('componentes/navbar') ?>

  <section class="section">
    <div class="container">
      <?= $this->renderSection('contenido') ?>
    </div>
  </section>

  <?= view('componentes/footer') ?>
</body>
</html>
