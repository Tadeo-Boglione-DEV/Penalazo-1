<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/subir.css">
    <link rel="stylesheet" href="./css/inicio.css">
    <link rel="shortcut icon" href="./img/logo.png">
    <title>Subir Equipos y Jugadores</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            background-image: url('./img/neuer.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: #fff;
            margin: 0;
            padding: 0;
            text-align: center;
            flex-direction: column;
            align-items: center;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin-bottom: 20px;
            text-align: left;
            display: inline-block;
            margin-top: 20px;
        }

        form h2 {
            font-size: 24px;
            color: #000;
            margin-bottom: 15px;
            text-align: center;
        }

        input[type="text"],
        input[type="file"],
        select {
            width: 93%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #00bcd4;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 12px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0097a7;
        }

        select {
            font-size: 14px;
        }

        .equipo-actual {
            display: none;
        }

        select[name="estado"]:checked + .equipo-actual {
            display: block;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: auto;
            width: 100%;
            margin-top: 20px;
        }

        label {
            color: #000;
            font-size: 14px;
        }

        .message {
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            text-align: center;
            font-weight: bold;
        }

        .success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
    </style>
</head>
<body>

<?= view('Includes/Header') ?>

<!-- Contenedor para los formularios -->
<div class="form-container">
    <!-- Formulario Subir Equipo -->
    <form action="http://localhost/Penalazo-1/public/equipos/subir" method="post" enctype="multipart/form-data">
        <h2>Subir un Equipo</h2>
        
        <!-- Mostrar mensaje de éxito o error solo para el equipo -->
        <?php if(session()->getFlashdata('success') && strpos(session()->getFlashdata('success'), 'Equipo') !== false): ?>
            <div class="message success">
                <?= session()->getFlashdata('success'); ?>
            </div>
        <?php elseif(session()->getFlashdata('error') && strpos(session()->getFlashdata('error'), 'Equipo') !== false): ?>
            <div class="message error">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <input type="text" name="nombre" placeholder="Nombre del equipo" required><br>
        <input type="text" name="pais" placeholder="País"><br>
        <input type="text" name="liga" placeholder="Liga"><br>

        <label for="imagen">Subir Imagen:</label><br>
        <input type="file" name="imagen" required><br>
        <button type="submit">Subir Equipo</button>
    </form>

    <!-- Formulario Subir Jugador -->
    <form action="http://localhost/Penalazo-1/public/jugadores/subir" method="post" enctype="multipart/form-data">
        <h2>Subir un Jugador</h2>
        
        <!-- Mostrar mensaje de éxito o error solo para el jugador -->
        <?php if(session()->getFlashdata('success') && strpos(session()->getFlashdata('success'), 'Jugador') !== false): ?>
            <div class="message success">
                <?= session()->getFlashdata('success'); ?>
            </div>
        <?php elseif(session()->getFlashdata('error') && strpos(session()->getFlashdata('error'), 'Jugador') !== false): ?>
            <div class="message error">
                <?= session()->getFlashdata('error'); ?>
            </div>
        <?php endif; ?>

        <input type="text" name="nombre" placeholder="Nombre del jugador" required><br>
        <input type="text" name="nacionalidad" placeholder="Nacionalidad"><br>
        <input type="text" name="posicion" placeholder="Posición"><br>

        <select name="estado" onchange="toggleEquipoActual()">
            <option value="actual">Actual</option>
            <option value="retirado">Retirado</option>
        </select><br>

        <div class="equipo-actual">
            <input type="text" name="equipo_actual" placeholder="Equipo actual"><br>
        </div>

        <label for="imagen">Subir Imagen:</label><br>
        <input type="file" name="imagen" required><br>
        <button type="submit">Subir Jugador</button>
    </form>
</div>

<?= view('Includes/Footer') ?>

<script>
    function toggleEquipoActual() {
        var estado = document.querySelector("select[name='estado']").value;
        var equipoActualField = document.querySelector(".equipo-actual");

        if (estado === "actual") {
            equipoActualField.style.display = "block";
        } else {
            equipoActualField.style.display = "none";
        }
    }

    window.onload = function() {
        toggleEquipoActual();
    };
</script>

</body>
</html>
