<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Solicitud incorrecta - Error 400</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .error-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            flex-direction: column;
            padding: 2rem;
        }
        h1 {
            font-size: 6rem;
            font-weight: 700;
            color: #ffc107;
        }
        h2 {
            font-weight: 400;
            color: #6c757d;
        }
        p {
            margin-top: 1rem;
            color: #6c757d;
        }
        .btn-home {
            margin-top: 2rem;
        }
    </style>
</head>
<body>

<div class="error-container">
    <h1>400</h1>
    <h2>¡Solicitud incorrecta!</h2>
    <p>La solicitud enviada no es válida o está incompleta.</p>

    <?php if (ENVIRONMENT !== 'production' && isset($message)) : ?>
        <div class="alert alert-warning mt-4 text-start" style="max-width: 600px; margin: auto;">
            <strong>Detalles del error:</strong><br>
            <?= nl2br(esc($message)) ?>
        </div>
    <?php endif; ?>

    <a href="<?= base_url() ?>" class="btn btn-warning btn-home">Volver al inicio</a>
</div>

</body>
</html>
