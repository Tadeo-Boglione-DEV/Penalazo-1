<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/inicio.css">
    <link rel="stylesheet" href="./css/perfil.css">
    <link rel="shortcut icon" href="./img/logo.png">
    <title>Perfil</title>
    <style>
         body {
    font-family: Arial, sans-serif;
    background-color: #000; /* Alternativa si la imagen no carga */
    background-image: url('./img/gabriel.jpg');
    background-size: cover;
    background-position: center;
    background-attachment: fixed; /* Mantiene el fondo fijo */
    color: #fff;
    margin: 0;
    padding: 0;
    text-align: center;
}
    </style>
</head>
<body>

<?= view('Includes/Header') ?>

<?php if (isset($usuario)) : ?>
    <div class="profile-container">
        <h2>Perfil de <?= esc($usuario['usuario']) ?></h2>
        <div class="profile-info">
            <p><strong>Usuario:</strong> <?= esc($usuario['usuario']) ?></p>
            <p><strong>Email:</strong> <?= esc($usuario['email']) ?></p>
            <a href="<?= base_url('/logout') ?>" class="logout-btns">Cerrar sesión</a>
        </div>
    </div>
<?php else : ?>
    <p>No se encontró la información del usuario.</p>
<?php endif; ?>

<?= view('Includes/Footer') ?>

</body>
</html>