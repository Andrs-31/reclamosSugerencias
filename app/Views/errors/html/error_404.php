<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Página no encontrada - Error 404</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bulma CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
        }
        
        .error-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .error-icon {
            color: #38bdf8;
            font-size: 5rem;
            margin-bottom: 1.5rem;
        }
        
        .error-title {
            color: #0c4a6e;
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .error-subtitle {
            color: #0369a1;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .error-message {
            color: #64748b;
            margin-bottom: 2rem;
        }
        
        .button.is-sky {
            background-color: #38bdf8;
            color: white;
            transition: all 0.3s ease;
        }
        
        .button.is-sky:hover {
            background-color: #0ea5e9;
            transform: translateY(-2px);
        }
        
        .error-animation {
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-15px);
            }
        }
    </style>
</head>
<body>
    <section class="section">
        <div class="container">
            <div class="error-container has-text-centered">
                <div class="error-animation">
                    <i class="fas fa-compass error-icon"></i>
                    <h1 class="error-title">404</h1>
                </div>
                <h2 class="error-subtitle">¡Ups! Página no encontrada</h2>
                <p class="error-message">
                    Lo sentimos, no pudimos encontrar la página que estás buscando. 
                    Puede que la dirección sea incorrecta o la página se haya movido.
                </p>
                <div class="buttons is-centered">
                    <a href="#" onclick="volver()" class="button is-sky is-medium">
                        <span class="icon">
                            <i class="fas fa-arrow-left"></i>
                        </span>
                        <span>Volver</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Optional JavaScript for Bulma -->
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <script>
function volver() {
    if (document.referrer && document.referrer !== location.href) {
        history.back();
    } else {
        // Redirige a una ruta por defecto dentro de tu proyecto
        window.location.href = '/reclamosSugerencias/public/';
    }
}
</script>
</body>
</html>