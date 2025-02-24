<?php
use CodeIgniter\HTTP\URI;

$uri = service('uri'); 
$currentSegment = $uri->getSegment(1); // Obtiene la primera parte de la URL

// Verifica si estás en "home"
$isHome = ($currentSegment === 'home');

// Verifica si hay un usuario en sesión
$session = session();
$usuarioEnSesion = $session->get('usuario');
?>

<header>
    <div class="logo" onclick="toggleLogo(this)">
        <img src="./img/logo.png" alt="Logo" class="logo-img">
    </div>
    <h1><span class="pena">PENA</span><span class="lazo">LAZO</span></h1>

    <?php if ($usuarioEnSesion) : ?>
        <div class="user-info">
            <span class="username"><?= esc($usuarioEnSesion) ?></span>
            <a href="<?= base_url('/home') ?>" class="profile-icon">
                <img src="./img/home.png" alt="Home">
            </a>
            <a href="<?= base_url('/subir') ?>" class="profile-icon">
                <img src="./img/up.png" alt="Subir">
            </a>
            <a href="<?= base_url('/perfil') ?>" class="profile-icon">
                <img src="./img/user.png" alt="Perfil">
            </a>
            <button class="logout-btn" onclick="logout()"> 
                <img src="./img/apagado.png" alt="Cerrar sesión">
            </button>
        </div>
    <?php else : ?>
        <a href="<?= base_url('/login') ?>">
            <button class="login-btn">Iniciar Sesión</button>
        </a>
    <?php endif; ?>

    <?php if ($isHome) : ?>
        <div class="header-bar"></div> <!-- Barra celeste solo en home -->
    <?php endif; ?>
</header>

<script>
    function logout() {
        window.location.href = "<?= base_url('/logout') ?>";
    }
</script>

