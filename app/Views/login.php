<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/login.css">
    <link rel="shortcut icon" href="./img/logo.png">
    <title>Login</title>
</head>
<body>
    <div class="login-container">
        <div class="image-section">
        </div>
        <div class="form-section">
            <h2><span style="color: #60c0f9;">¡Hola</span>, Futboleros!</h2>
            <div class="tab-container">
                <span class="tab active-tab">Iniciar Sesión</span>
                <span class="tab" onclick="window.location.href='<?= base_url('register') ?>'">Registrarse</span>
            </div>
            <?php if (session()->getFlashdata('success')) : ?>
    <div class="success-message"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
            <form action="<?= base_url('/login/auth') ?>" method="post">
            <?php if (session()->getFlashdata('error')) : ?>
    <div class="error-message">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>


    <div class="input-group">
        <input type="email" name="email" placeholder="Escribe tu email" required>
    </div>
    <div class="input-group">
        <input type="password" name="password" id="password" placeholder="Escribe tu contraseña" required>
        <img src="./img/invisible.png" alt="Mostrar contraseña" class="eye-icon" id="togglePassword">
    </div>
    <button type="submit" class="login-btn">Iniciar Sesión</button>
</form>
            <div class="register-link">
                ¿No tienes cuenta? <span class="register-text" onclick="window.location.href='register'">Registrarse</span>
            </div>
        </div>
    </div>
    <div class="home-button" id="homeButton">
    <div class="progress"></div>
    <img src="https://cdn-icons-png.flaticon.com/512/25/25694.png" alt="Home">
</div>

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
    <script>
        document.getElementById("togglePassword").addEventListener("click", function () {
            let passwordInput = document.getElementById("password");
            let icon = document.getElementById("togglePassword");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.src = "./img/ojo.png"; 
            } else {
                passwordInput.type = "password";
                icon.src = "./img/invisible.png"; 
            }
        });
    </script>
</body>
</html>
