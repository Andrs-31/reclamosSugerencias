<!--MODIFICADO POR JAFETH J -->

<?= $this->extend('layouts/template_login'); ?>
<?= $this->section('content'); ?>

<div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
    <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%;">
        <div class="card-body">
            <h1 class="fs-4 card-title fw-bold mb-4 text-center">Iniciar sesión</h1>
            <form method="POST" action="<?= base_url('login'); ?>" autocomplete="off">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="username" class="form-label">Usuario o Correo</label>
                    <input type="text" class="form-control" name="username" id="username" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                </div>
            </form>

            <?php if (session('error')): ?>
                <div class="alert alert-danger mt-3" role="alert">
                    <?= session('error'); ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="card-footer border-0 text-center bg-white pt-3">
            <small>¿No tienes una cuenta? <a href="<?= base_url('register') ?>" class="text-decoration-none">Regístrate aquí</a></small>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>

<style>
    body {
    background-color: #f8f9fa;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.form-control {
    font-size: 0.9rem;
    padding: 0.5rem 0.75rem;
}

.card {
    border-radius: 1rem;
}

</style>