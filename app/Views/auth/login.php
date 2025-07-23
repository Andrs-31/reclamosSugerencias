<?= $this->extend('layouts/template_login'); ?>
<?= $this->section('content'); ?>

<div class="login-container">
    <!-- Fondo con overlay -->
    
    <!-- Contenedor del formulario -->
    <div class="login-form-container">
        <div class="login-card">
            <div class="card-header text-center">
                <img src="<?= base_url('assets/images/logo.png') ?>" alt="Logo" class="logo">
                <h2>Iniciar sesión</h2>
                <p class="subtitle">Accede con tus credenciales</p>
            </div>
            
            <div class="card-body">
                <form method="POST" action="<?= base_url('login'); ?>" autocomplete="off">
                    <?= csrf_field() ?>
                    
                    <div class="form-group">
                        <label for="username">Usuario o Correo</label>
                        <div class="input-with-icon">
                            <i class="bi bi-person-fill"></i>
                            <input type="text" id="username" name="username" required autofocus placeholder="usuario@ejemplo.com">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <div class="input-with-icon">
                            <i class="bi bi-lock-fill"></i>
                            <input type="password" id="password" name="password" required placeholder="••••••••">
                            <button type="button" class="toggle-password" aria-label="Mostrar contraseña">
                                <i class="bi bi-eye-fill"></i>
                            </button>
                        </div>
                    </div>
                    
                    
                    <button type="submit" class="login-button">
                        <i class="bi bi-box-arrow-in-right"></i> Ingresar
                    </button>
                    
                    <?php if (session('error')): ?>
                        <div class="alert-message">
                            <i class="bi bi-exclamation-circle-fill"></i>
                            <?= session('error'); ?>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
            
            <div class="card-footer">
                <p>¿No tienes una cuenta? <a href="<?= base_url('register') ?>">Regístrate aquí</a></p>
            </div>
        </div>
    </div>
</div>

<!-- ESTILOS -->
<style>
:root {
    --primary-color: #4361ee;
    --primary-dark: #3a56d4;
    --text-color: #2b2d42;
    --text-light: #8d99ae;
    --border-color: #e9ecef;
    --error-color: #ef233c;
    --white: #ffffff;
    --background-overlay: rgba(0, 0, 0, 0.5);
}

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}



/* Contenedor principal centrado */

.login-container {
    height: 100vh; /* Asegura que ocupe toda la altura de la pantalla */
    display: flex;
    justify-content: center; /* Centra horizontalmente */
    align-items: center;     /* Centra verticalmente */
    z-index: 1;
    position: relative;
    padding: 20px 5%;
}



/* Formulario */
.login-form-container {
    position: relative;
    z-index: 2;
    width: 100%;
    max-width: 420px;
}

.login-card {
    background-color: var(--white);
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    overflow: hidden;
}

.card-header {
    padding: 32px 32px 24px;
    text-align: center;
}

.card-header .logo {
    width: 70px;
    height: 70px;
    object-fit: contain;
    margin-bottom: 16px;
}

.card-header h2 {
    color: var(--text-color);
    font-size: 1.75rem;
    font-weight: 600;
    margin-bottom: 8px;
}

.card-header .subtitle {
    color: var(--text-light);
    font-size: 0.95rem;
}

.card-body {
    padding: 0 32px 24px;
}

.card-footer {
    padding: 20px 32px;
    text-align: center;
    border-top: 1px solid var(--border-color);
    font-size: 0.9rem;
    color: var(--text-light);
}

.card-footer a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
}
.card-footer a:hover {
    text-decoration: underline;
}

/* Formulario */
.form-group {
    margin-bottom: 20px;
}
.form-group label {
    display: block;
    margin-bottom: 8px;
    color: var(--text-color);
    font-size: 0.9rem;
    font-weight: 500;
}

.input-with-icon {
    position: relative;
    display: flex;
    align-items: center;
}

.input-with-icon i {
    position: absolute;
    left: 14px;
    color: var(--text-light);
    font-size: 1.1rem;
}

.input-with-icon input {
    width: 100%;
    padding: 12px 16px 12px 42px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.input-with-icon input:focus {
    border-color: var(--primary-color);
    outline: none;
    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
}

.toggle-password {
    position: absolute;
    right: 12px;
    background: none;
    border: none;
    color: var(--text-light);
    cursor: pointer;
    font-size: 1.1rem;
    padding: 5px;
}
.toggle-password:hover {
    color: var(--text-color);
}

/* Opciones */
.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 20px 0;
    font-size: 0.85rem;
}
.form-check {
    display: flex;
    align-items: center;
}
.form-check input {
    margin-right: 8px;
    accent-color: var(--primary-color);
}
.form-check label {
    color: var(--text-light);
    margin-bottom: 0;
    cursor: pointer;
}
.forgot-password {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
}
.forgot-password:hover {
    text-decoration: underline;
}

/* Botón login */
.login-button {
    width: 100%;
    padding: 14px;
    background-color: var(--primary-color);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.login-button:hover {
    background-color: var(--primary-dark);
    transform: translateY(-1px);
}
.login-button:active {
    transform: translateY(0);
}

/* Alerta */
.alert-message {
    margin-top: 20px;
    padding: 12px;
    background-color: #fef2f2;
    color: var(--error-color);
    border-radius: 8px;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

/* Responsive */
@media (max-width: 480px) {
    .login-container {
        padding: 16px;
    }

    .card-header, .card-body, .card-footer {
        padding-left: 24px;
        padding-right: 24px;
    }

    .card-header {
        padding-top: 24px;
    }
}
</style>


<?= $this->endSection(); ?>