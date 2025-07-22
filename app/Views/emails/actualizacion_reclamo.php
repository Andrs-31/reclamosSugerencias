<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Actualización en su reclamo #<?= $reclamoId ?></title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background-color: #f8f9fa; padding: 20px; text-align: center; }
        .content { padding: 20px; background-color: #fff; }
        .footer { margin-top: 20px; padding: 10px; text-align: center; font-size: 0.9em; color: #666; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Actualización en su reclamo #<?= $reclamoId ?></h2>
        </div>
        
        <div class="content">
            <p>Estimado ciudadano,</p>
            
            <p>Se ha actualizado el estado de su reclamo <strong>#<?= $reclamoId ?></strong>:</p>
            
            <p><strong>Nuevo estado:</strong> <?= $estado ?></p>
            
            <?php if (!empty($comentario)): ?>
            <p><strong>Comentario:</strong></p>
            <blockquote style="border-left: 3px solid #ddd; padding-left: 15px; margin-left: 0;">
                <?= nl2br(htmlspecialchars($comentario)) ?>
            </blockquote>
            <?php endif; ?>
            
            <p>Puede ver los detalles ingresando a la plataforma.</p>
            <li><a href="http://localhost/reclamosSugerencias/public/">Ir a la plataforma</a></li>
        </div>
        
        <div class="footer">
            <p>Este es un mensaje automático, por favor no responda a este correo.</p>
            <p>© <?= date('Y') ?> Sistema de Reclamos Municipales</p>
        </div>
    </div>
</body>
</html>