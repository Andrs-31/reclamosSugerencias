<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Login' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('css/style-login.css'); ?>" rel="stylesheet">

    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        .background-image {
            background-color: #0b1e3d; /* Azul marino oscuro */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
        }

        .background-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.3); /* Oscurece un poco más */
            z-index: -1;
        }

        .z-2 {
            position: relative;
            z-index: 2;
        }
    </style>
</head>
<body class="login-layout">
    <div class="background-image"></div>
    <div class="background-overlay"></div>

    <div class="container position-relative z-2">
        <?= $this->renderSection('content'); ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
