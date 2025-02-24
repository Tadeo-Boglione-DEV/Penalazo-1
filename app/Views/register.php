<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/register.css">
    <link rel="shortcut icon" href="./img/logo.png">
    <title>Registrarse</title>
</head>
<body>
<div class="register-container">
        <div class="form-section">
            <h2><span style="color: red;">¡Bienvenidos</span> a PENALAZO!</h2>

            <div class="tab-container">
                <span class="tab" onclick="window.location.href='<?= base_url('login') ?>'">Iniciar Sesión</span>
                <span class="tab active-tab">Registrarse</span>
            </div>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="error-message"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')) : ?>
                <div class="success-message"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('/register'); ?>">
                <div class="input-group">
                    <input type="email" name="email" placeholder="Escribe tu email" required>
                </div>
                <div class="input-group">
                    <input type="text" name="usuario" placeholder="Crea tu usuario" required>
                </div>
                <div class="input-group">
    <input type="password" id="password" name="password" placeholder="Crea tu contraseña" required>
    <img src="./img/invisible.png" alt="Mostrar contraseña" class="eye-icon" id="togglePassword">
    <p id="passwordError" class="password-error" style="display: none;"></p>

</div>
                <button type="submit" class="register-btn">Registrarse</button>
            </form>

            <div class="login-link">
                ¿Tienes cuenta? <span class="login-text" onclick="window.location.href='<?= base_url('login') ?>'">Inicia Sesión</span>
            </div>
        </div>
        <div class="image-section"></div>
    </div>

    <div class="home-button" id="homeButton">
    <div class="progress"></div>
    <img src="https://cdn-icons-png.flaticon.com/512/25/25694.png" alt="Home">
</div>

<script src="<?= base_url('js/register.js') ?>"></script>

<script>
    let timer;
    let completed = false;

    document.getElementById("homeButton").addEventListener("mousedown", function () {
        document.querySelector(".progress").style.transition = "transform 3s linear";
        document.querySelector(".progress").style.transform = "scaleY(0)";
        
        timer = setTimeout(() => {
            completed = true; // Se marca como completado
        }, 3000);
    });

    document.getElementById("homeButton").addEventListener("mouseup", function () {
        if (completed) {
            window.location.href = "home"; // Redirige solo si se completó
        } else {
            resetProgress();
        }
    });

    document.getElementById("homeButton").addEventListener("mouseleave", function () {
        resetProgress();
    });

    function resetProgress() {
        clearTimeout(timer);
        completed = false;
        document.querySelector(".progress").style.transition = "transform 0.3s ease";
        document.querySelector(".progress").style.transform = "scaleY(1)";
    }
</script>

</body>
</html>
