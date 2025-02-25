<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/subir.css">
    <link rel="stylesheet" href="./css/inicio.css">
    <link rel="shortcut icon" href="./img/logo.png">
    <title>Subir Equipos y Jugadores</title>
</head>
<body>

<?= view('Includes/Header') ?>

<div class="form-container">
    <form action="http://localhost/Penalazo-1/public/equipos/subir" method="post">
        <h2>Subir un Equipo</h2>
        <input type="text" name="nombre" placeholder="Nombre del equipo" required><br>
        <input type="text" name="pais" placeholder="País"><br>
        <input type="text" name="liga" placeholder="Liga"><br>
        <button type="submit">Subir Equipo</button>
    </form>

    <!-- Formulario Subir Jugador -->
<form action="http://localhost/Penalazo-1/public/jugadores/subir" method="post">
    <h2>Subir un Jugador</h2>

    <input type="text" name="nombre" placeholder="Nombre del jugador" required><br>
    <input type="text" name="nacionalidad" placeholder="Nacionalidad"><br>

    <label for="posicion">Posición:</label>
    <select name="posicion" required>
        <option value="Arquero">Arquero</option>
        <option value="Defensa">Defensa</option>
        <option value="Mediocampista">Mediocampista</option>
        <option value="Delantero">Delantero</option>
    </select><br>

    <label for="fecha_de_nacimiento">Fecha de nacimiento:</label>
    <input type="date" name="fecha_de_nacimiento" required><br>

    <select name="estado" onchange="toggleEquipoActual()">
        <option value="actual">Actual</option>
        <option value="retirado">Retirado</option>
    </select><br>

    <div class="equipo-actual">
        <input type="text" name="equipo_actual" placeholder="Equipo actual"><br>
    </div>

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

<script>
        function toggleLogo(element) {
            const img = element.querySelector('.logo-img');
            element.classList.toggle('flipped');
            setTimeout(() => {
                img.src = element.classList.contains('flipped') ? './img/logo2.png' : './img/logo.png';
            }, 250);
        }
    </script>

</body>
</html>
